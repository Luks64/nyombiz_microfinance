<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('applicant_id')->assign()->nullable();
            $table->decimal('amount_applied_for',10,2);
            // $table->decimal('amount_given',10,2);
            // $table->integer('period_in_months');
            $table->decimal('interest',10,2);
            $table->string('purpose');
            $table->date('date_when_required');
            $table->date('date_of_issue');
            $table->string('security1');
            $table->decimal('security1_value',10,2)->nullable();
            $table->string('security2')->nullable();
            $table->decimal('security2_value',10,2)->nullable();
            $table->string('security3')->nullable();
            $table->decimal('security3_value',10,2)->nullable();
            $table->string('guarantor1_name')->nullable();
            $table->string('guarantor1_phone')->nullable();;
            $table->string('guarantor2_name')->nullable();;
            $table->string('guarantor2_phone')->nullable();;
            $table->enum('payment_mode', ['daily', 'weekly', 'monthly', 'yearly']);
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
        Schema::dropIfExists('loans');
    }
}
