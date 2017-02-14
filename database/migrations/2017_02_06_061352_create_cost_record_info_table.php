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
        Schema::connection('mysql')->create('cost_record_info', function(Blueprint $table){
        	$table->increments('id')->unique();
        	$table->string('URI')->unique();
        	$table->string('dbp_buyer');
			$table->string('rdf_type');
			$table->string('dbo_year');
			$table->string('dbo_month');
			$table->string('dbo_date');
			$table->string('dbp_commodity');
			$table->string('dbo_currency');
			$table->integer('dbo_price');
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
