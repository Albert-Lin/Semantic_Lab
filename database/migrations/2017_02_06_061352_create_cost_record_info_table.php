<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostRecordInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cost_record_info', function(Blueprint $table){
        	$table->increments('id')->unique();
        	$table->string('URI')->unique();
        	$table->string('slp:purchaser');
			$table->string('rdf:type');
			$table->string('dbo:year');
			$table->string('dbo:month');
			$table->string('dbo:date');
			$table->string('dbp:commodity');
			$table->string('dbo:currency');
			$table->integer('dbo:price');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
