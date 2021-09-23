<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('employee_id');
            $table->integer('amount');
            $table->integer('invoice_nu');
            $table->string('username');
            $table->integer('total');
            $table->integer('return');
            $table->integer('u_company_id');
            $table->string('details');
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
        Schema::dropIfExists('payings');
    }
}
