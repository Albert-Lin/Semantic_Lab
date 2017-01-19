<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table with schema:
        // Blueprint object that may be used to define the new table ($table)
        Schema::create('user_infos', function(Blueprint $table){
            $table->increments('id'); // function increments() used to create a auto-increments column
            $table->string('name'); // function string() used to create a column with VARCHAR type
            $table->string('password');
            $table->string('hashPassword');
            $table->string('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the table
        Schema::drop('user_infos');
    }
}
