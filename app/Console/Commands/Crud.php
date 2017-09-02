<?php

namespace App\Console\Commands;

use DirectoryIterator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Crud extends Command
{
    protected $signature = 'make:crud {model} {stubs=default}';
    protected $description = 'Generate CRUD files.';
    public $replace_attributes = [];
    public $replace_model = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $crud_file = resource_path('crud/' . $this->argument('model') . '.php');

        if (file_exists($crud_file)) {
            // set replace property and generate with it
            $attributes = include $crud_file;
            $this->setReplaceAttributes($attributes)->setReplaceModel()->generate();

            // ask to migrate
            if ($this->ask('Migrate now? [y/n]') == 'y') {
                Artisan::call('migrate');
                $this->info('Migration complete!');
            }

            // output success message
            $this->info($this->argument('model') . ' CRUD generated!');
        }
        else {
            // crud file does not exist, show error
            $this->error('Error: '.$crud_file . ' does not exist.');
        }
    }

    public function setReplaceAttributes($attributes)
    {
        $replace = [];

        foreach ($attributes as $name => $options) {
            // schema
            if (isset($options['schema'])) {
                $replace['/* crud_schema */'][] = $this->replaceAttribute('database/schema.php', $name, $options);
            }

            // input (_create & _update)
            if (isset($options['input'])) {
                foreach (['create', 'update'] as $action) {
                    $replace['<!-- crud_input_' . $action . ' -->'][] = $this->replaceAttribute('views/input/' . $action . '/' . $this->replaceInput($options) . '.blade.php', $name, $options);
                }
            }

            // rule (_create & _update)
            foreach (['create', 'update'] as $action) {
                if (isset($options['rule_'.$action])) {
                    $replace['/* crud_rule_' . $action . ' */'][] = $this->replaceAttribute('controller/rule/' . $action . '.php', $name, $options);
                }
            }

            // datatable
            if (isset($options['datatable']) && $options['datatable']) {
                $replace['<!-- crud_datatable_heading -->'][] = $this->replaceAttribute('views/datatable/heading.blade.php', $name, $options);
                $replace['/* crud_datatable_column */'][] = $this->replaceAttribute('views/datatable/column.blade.php', $name, $options);
            }
        }

        $replace['/* crud_fillable */'] = 'protected $fillable = ["' . implode('", "', array_keys($attributes)) . '"];';

        foreach ($replace as $key => $values) {
            $this->replace_attributes[$key] = trim(is_array($values) ? implode(PHP_EOL, $values) : $values);
        }

        return $this;
    }

    public function replaceAttribute($file_path, $name, $options)
    {
        $stub_file = $this->stubPath($file_path);

        if (file_exists($stub_file)) {
            $content = file_get_contents($stub_file);

            foreach ($options as $key => $value) {
                $content = str_replace('crud_attribute_' . $key, $value, $content);
            }

            $content = str_replace('crud_attribute_name', $name, $content);
            $content = str_replace('crud_attribute_label', ucwords(str_replace('_', ' ', $name)), $content);
        }

        return isset($content) ? $content : null;
    }

    public function replaceInput($options)
    {
        $input = isset($options['input']) ? $options['input'] : null;

        if (in_array($input, ['text', 'password', 'email', 'number', 'tel', 'url'])) {
            $input = 'input';
        }
        else if (in_array($input, ['radio', 'checkbox'])) {
            $input = 'check';
        }

        return $input;
    }

    public function setReplaceModel()
    {
        $singular = $this->argument('model');
        $plural = str_plural($singular);

        $this->replace_model = [
            'crud_model_class' => str_replace(' ', '', $singular),
            'crud_model_variables' => str_replace(' ', '_', strtolower($plural)),
            'crud_model_variable' => str_replace(' ', '_', strtolower($singular)),
            'crud_model_strings' => $plural,
            'crud_model_string' => $singular,
        ];

        return $this;
    }

    public function generate()
    {
        // create migration file
        $this->createFile('database/migration.php', database_path('migrations/' . date('Y_m_d_000000', time()) . '_create_' . $this->replace_model['crud_model_variable'] . '_table.php'));

        // create model file
        $this->createFile('model.php', app_path($this->replace_model['crud_model_class'] . '.php'));

        // create controller file
        $this->createFile('controller/controller.php', app_path('Http/Controllers/Backend/' . $this->replace_model['crud_model_class'] . 'Controller.php'));

        // create view files
        $stub_views_folder = $this->stubPath('views');

        if (file_exists($stub_views_folder)) {
            $stub_views_files = new DirectoryIterator($stub_views_folder);
            $create_views_folder = resource_path('views/backend/' . $this->replace_model['crud_model_variables']);

            // create new views folder if it doesn't exist
            if (!file_exists($create_views_folder)) {
                mkdir($create_views_folder);
            }

            // loop through all view stubs and create
            foreach ($stub_views_files as $stub_views_file) {
                if (!$stub_views_file->isDot() && !$stub_views_file->isDir() && $stub_views_file->getFilename() != 'navbar.blade.php') {
                    $this->createFile('views/' . $stub_views_file->getFilename(), $create_views_folder . '/' . $stub_views_file->getFilename());
                }
            }
        }

        // add menu item to navbar
        $this->updateFile('views/navbar.blade.php', resource_path('views/layouts/app.blade.php'), '<!-- crud_navbar -->');

        // add routes to web
        $this->updateFile('routes.php', base_path('routes/web.php'), '/* crud_routes */');
    }

    public function createFile($file_path, $create_path)
    {
        $stub_file = $this->stubPath($file_path);

        if (file_exists($stub_file)) {
            file_put_contents($create_path, $this->replaceContent($stub_file));
            $this->line('Created file: '.$create_path);
        }
    }

    public function updateFile($file_path, $update_path, $hook)
    {
        $stub_file = $this->stubPath($file_path);
        $update_file = file_get_contents($update_path);
        $content = $this->replaceContent($stub_file);

        if (file_exists($stub_file) && strpos($update_file, $content) === false) {
            file_put_contents($update_path, str_replace($hook, $hook . PHP_EOL . $content, $update_file));
            $this->line('Updated file: '.$update_path);
        }
    }

    public function stubPath($file_path)
    {
        return resource_path('crud/stubs/' . $this->argument('stubs') . '/' . $file_path);
    }

    public function replaceContent($file)
    {
        $content = file_get_contents($file);
        $content = strtr($content, $this->replace_attributes);
        $content = strtr($content, $this->replace_model);

        return $content;
    }
}
