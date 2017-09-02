<?php

use App\Permission;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Createcrud_model_classTable extends Migration
{
    public function up()
    {
        Schema::create('crud_model_variables', function (Blueprint $table) {
            $table->increments('id');
            /* crud_schema */
            $table->timestamps();
        });

        // create permissions
        Permission::create(['group' => 'crud_model_strings', 'name' => 'View crud_model_strings']);
        Permission::create(['group' => 'crud_model_strings', 'name' => 'Create crud_model_strings']);
        Permission::create(['group' => 'crud_model_strings', 'name' => 'Update crud_model_strings']);
        Permission::create(['group' => 'crud_model_strings', 'name' => 'Delete crud_model_strings']);
    }

    public function down()
    {
        Schema::dropIfExists('crud_model_variables');

        // delete permissions
        Permission::where('group', 'crud_model_strings')->delete();
    }
}
