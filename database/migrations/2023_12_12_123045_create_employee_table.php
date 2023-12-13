<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('employee', function (Blueprint $table) {
            $table->increments('employee_id');
            $table->unsignedInteger('job_title_id');
            $table->foreign('job_title_id')->references('job_title_id')->on('job_titles');
            $table->decimal('salary');
            $table->unsignedInteger('branch_id');
            $table->foreign('branch_id')->references('branch_id')->on('branch');
            $table->unsignedInteger('profile_id');
            $table->foreign('profile_id')->references('profile_id')->on('profile');
            $table->index('employee_id');
            $table->index('job_title_id');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee');
    }
}
