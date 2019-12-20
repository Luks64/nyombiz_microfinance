<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('group_no')->nullable();
            $table->string('name');
            $table->integer('employee_id')->assign()->nullable();
            $table->string('meeting_day')->nullable();
            $table->string('meeting_frequency'); // weekly, bi-weekly, monthly
            $table->string('location')->nullable();
            $table->string('activity')->nullable();
            $table->date('creation_date');
            $table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('groups');
    }
}
