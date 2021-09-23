<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('name');
            $table->string('education');
            $table->string('specilized');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('note');
            $table->string('password');
            $table->string('generator');
            $table->string('cashier');
            $table->string('edit_invoices');
            $table->string('see_allinvoices');
            $table->string('delete_invoices');
            $table->string('expenser');
            $table->string('edit_expenses');
            $table->string('see_allexpenses');
            $table->string('delete_expenses');

            $table->string('generator1');
            $table->string('edit_invoice1s');
            $table->string('see_allinvoice1s');
            $table->string('delete_invoice1s');
            
            $table->string('paying');
            $table->string('edit_payings');
            $table->string('see_allpayings');
            $table->string('delete_payings');

            $table->string('paid');
            $table->string('edit_paids');
            $table->string('see_allpaids');
            $table->string('delete_paids');
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
        Schema::dropIfExists('employees');
    }
}
