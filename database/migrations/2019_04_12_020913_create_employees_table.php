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
            $table->string('employee_no');
            $table->string('name');
            $table->string('gender');
            $table->string('marital_status'); // single, married, divorced, widowed
            $table->string('position');
            $table->decimal('monthly_salary',13,2)->nullable();
            $table->string('residence');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->date('birth_date');
            $table->date('start_date');
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
