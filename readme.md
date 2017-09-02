![Owl](https://i.imgur.com/QydYf5c.png)

# Owl

Laravel 5.5 scaffolding with:

* Frontend & backend
* CRUD generator command with stub templates
* Auth
* Secure sessions
* Roles & permissions
* Changeable settings
* Contact form
* reCAPTCHA
* Activity log
* Demo mode
* User-specified timezones
* AJAX form validation
* AJAX CRUD
* Bootstrap 4
* Responsive on all devices
* DataTables
* FontAwesome
* & more

## Useful Links

* Repo: https://github.com/kjdion84/owl
* Demo: http://owldemo.kjdion.com
* Videos: https://www.youtube.com/channel/UCeYkrwYJ2WY4ABSU0bAl2cg

# Installation

1. Copy/clone repo files
2. Create virtual host pointing to `/public` folder
3. Create database with `utf8mb4_unicode_ci` collation
4. Create SMTP server
5. Create and edit `.env` file using `.env.example` as an example
6. Run `composer update`
7. Run `php artisan migrate`

Now you can visit the app URL in your browser and login with:

* Email: admin@example.com
* Password: admin123

You'll probably want to change that email/password right away.

# Configuration

You can enable/disable the core scaffolding features inside of `config/owl.php`:

* `allow.frontend`: enable/disable the frontend.
* `allow.registration`: enable/disable user registration.
* `allow.contact`: enable/disable the contact form.
* `demo`: enable/disable demo mode (disables CRUD methods via model events; see `app/Traits/Owl.php` code).

There are also additional settings stored in the database, allowing for dynamic app settings to be created/managed with ease. Access these settings using `config('settings.key')`.

Note: you must enter your reCAPTCHA keys in the `settings` database table (or via the UI `Manage -> Settings` menu) in order for reCAPTCHA to display in the register/contact forms.

# Usage

## Scripts & Styles

I've created empty `app.css` and `app.js` files in the `public/` folder. I recommend using these files for app logic so that the scaffolding files remain intact.

## Responses

Each controller returns a JSON response for CRUD operations. This is due to the form validation AJAX. Each JSON key you return has a specific function:

* `redirect`: redirects user to specified URL e.g. `'redirect' => route('index')`
* `flash`: flashes alert briefly using bs4 class e.g. `'flash' => ['success', 'User created!']`
* `dismiss_modal`: closes the current model the form is in.
* `reload_datatables`: reloads datatables on the page to display new/updated data.

Play around and check source code to view how other things work.
    
# CRUD Generator Command

Use `php artisan make:crud {model} {stubs=default}` to generate CRUD files. This will generate a migration, model, controller, views, add a menu item, and routes.

You must make sure you create a `My Model.php` (note that spaces are used) file in the `resources/crud/` folder before running the command. This model file will contain all of the attribute definitions for the model, and their details such as schema, input type, controller rules, etc.

Examples: `php artisan make:crud "My Model"` or `php artisan make:crud "My Model" default`

## Command Arguments

### {model}

The singular name for your model (including spaces) e.g. `"My Model"`. A file called `My Model.php` must be present in the `resources/crud/` folder with the attribute definitions before running the command. See `resources/crud/Car.php` for an example.

### {stubs=default}

Optional folder name containing the stub templates used to generate with. This defaults to `default`. Stub template folders are found in `resources/crud/stubs`. Add as many templates as you want.

## Model Attribute Definitions

The CRUD command requires you to specify model attributes via a PHP file. See `resources/stubs/Car.php` for an example. Each key in this file represents the name of the attribute e.g. `post_title`.

The following options are available per attribute:

* `schema`: methods used for the migration column e.g. `string("crud_attribute_name")->nullable()`
* `input`: input type for forms, can be any one of `text`, `password`, `email`, `number`, `tel`, `url`, `radio`, `checkbox`, `select`, `textarea`.
* `rule_create`: rules used for creating by the controller e.g. `required|unique:crud_model_variables`
* `rule_update`: rules used for updating by the controller e.g. `required|unique:crud_model_variables,crud_attribute_name,$id` (note `$id`, this is a variable injected into the controller method)
* `datatable`: enable/disable showing this attribute in DataTables (boolean)

You can also completely remove any option you do not want to use per attribute. See the `description` attribute in `resources/crud/Car.php` for an example.

### CRUD Replacement Strings

There are a number of available replacement strings you will see in the stub template files and even the `Car.php` example file:

* `crud_attribute_name`: current attribute name e.g. `post_title`
* `crud_attribute_label`: current attribute label (automatically created using the attribute name) e.g. `Post Title`
* `crud_attribute_schema`: current attribute schema e.g. `string("crud_attribute_name")->nullable()`
* `crud_attribute_input`: current attribute input e.g. `textarea`
* `crud_attribute_rule_create`: current attribute create rule e.g. `required|unique:crud_model_variables`
* `crud_attribute_rule_update`: current attribute update rule e.g. `required|unique:crud_model_variables,crud_attribute_name,$id`
* `crud_attribute_datatable`: current attribute datatable boolean value e.g. `true`
* `crud_model_class`: model class name e.g. `BlogPost`
* `crud_model_variables`: plural model variable name e.g. `blog_posts`
* `crud_model_variable`: singular model variable name e.g. `blog_post`
* `crud_model_strings`: plural model title name e.g. `Blog Posts`
* `crud_model_string`: singular model title name e.g. `Blog Post`

You can use any of these replacement strings inside of the stub templates or model attribute definition files you create.

## Custom Stub Templates

You can easily copy and paste the `resources/crud/stubs/default` folder in order to create your own stubs for whatever purpose you desire. The command will check for files which exist in the specified folder when generating. Also, it will auto-create any views you place in the stub template `views/` folder (except for `navbar.blade.php`, which is used to add the navbar menu item). You will notice the use of replacement strings mentioned above in the `default` template files.

# Issues & Support

Use Github issues for bug reports, suggestions, help, & support.

# Donations

If you find this useful you can [donate via PayPal](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=kjdion84%40gmail%2ecom&lc=CA&item_name=Tiger&no_note=1&no_shipping=1&currency_code=CAD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted).