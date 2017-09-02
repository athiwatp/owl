<?php

use App\Permission;
use App\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key');
            $table->string('value')->nullable();
            $table->timestamps();
        });

        // create default settings
        Setting::create(['key' => 'title', 'value' => config('app.name')]);
        Setting::create(['key' => 'default_timezone', 'value' => config('app.timezone')]);
        Setting::create(['key' => 'recaptcha_site_key']);
        Setting::create(['key' => 'recaptcha_secret_key']);

        // create permissions
        Permission::create(['group' => 'Settings', 'name' => 'Update Settings']);
    }

    public function down()
    {
        Schema::dropIfExists('settings');

        // delete permissions
        Permission::where('group', 'Settings')->delete();
    }
}
