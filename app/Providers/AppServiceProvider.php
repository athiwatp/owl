<?php

namespace App\Providers;

use App\Setting;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use ReCaptcha\ReCaptcha;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // fix db string length error
        Schema::defaultStringLength(191);

        // config settings
        if (Schema::hasTable('settings')) {
            foreach (Setting::all() as $setting) {
                config(['settings.'.$setting->key => $setting->value]);
            }
        }

        // recaptcha validation rule
        Validator::extend('recaptcha', function ($attribute, $value, $parameters, $validator) {
            $recaptcha = new ReCaptcha(config('settings.recaptcha_secret_key'));
            $resp = $recaptcha->verify($value, request()->ip());

            return $resp->isSuccess();
        });

        // canany permission blade directive
        Blade::directive('canany', function ($permissions) {
            $permissions = array_map('trim', explode(',', $permissions));
            $conditional = [];

            foreach ($permissions as $permission) {
                $conditional[] = "Gate::check($permission)";
            }

            return "<?php if (".implode(' || ', $conditional)."): ?>";
        });
        Blade::directive('endcanany', function () {
            return '<?php endif; ?>';
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
