<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanRepaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_repayments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('loan_id')->assign()->nullable();
            $table->date('due_date');
            $table->date('date_repaid')->nullable();
            $table->decimal('principal',10,2);
            $table->decimal('principal_repaid',10,2)->nullable();
            $table->decimal('interest',10,2);
            $table->decimal('interest_repaid',10,2)->nullable();
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
        Schema::dropIfExists('loan_repayments');
    }
}
