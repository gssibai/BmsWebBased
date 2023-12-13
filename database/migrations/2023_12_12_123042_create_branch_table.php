<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('branch', function (Blueprint $table) {
            $table->increments('branch_id');
            $table->string('branch_name');
            $table->text('address');
            $table->unsignedInteger('city_id');
            $table->foreign('city_id')->references('city_id')->on('city');
            $table->char('zip_code');
            $table->integer('manager_id');
            $table->index('branch_id');
            $table->index('branch_name');
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
        Schema::dropIfExists('branch');
    }
}
