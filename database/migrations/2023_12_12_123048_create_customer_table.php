<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('customer', function (Blueprint $table) {
            $table->Increments('customer_id');
            $table->unsignedInteger('account_id');
            $table->foreign('account_id')->references('account_id')->on('account');
            $table->unsignedInteger('profile_id');
            $table->foreign('profile_id')->references('profile_id')->on('profile');
            $table->index('customer_id');
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
        Schema::dropIfExists('customer');
    }
}
