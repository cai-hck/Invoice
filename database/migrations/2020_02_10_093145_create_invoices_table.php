<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('generator_id');
            $table->integer('cashier_id');
            $table->string('name');
            $table->string('details');
            $table->integer('adult_no');
            $table->integer('child_no');
            $table->integer('infant_no');
            
            $table->integer('adult_buy');
            $table->integer('adult_sell');
            $table->integer('adult_fair');
            
            $table->integer('child_buy');
            $table->integer('child_sell');
            $table->integer('child_fair');

            $table->integer('infant_buy');
            $table->integer('infant_sell');
            $table->integer('infant_fair');
            
            $table->integer('source_id');
            $table->float('comission_source');
            $table->float('comission_passenger');
            $table->string('phone');
            $table->string('passport');
            $table->string('et');
            $table->Date('date_travel');
            $table->integer('airline_id');
            $table->float('to_pay');
            $table->string('note');
            $table->integer('paid');
            $table->integer('returned_balance_to_passenger');
            $table->integer('returned_balance_from_source');
            $table->string('status');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
