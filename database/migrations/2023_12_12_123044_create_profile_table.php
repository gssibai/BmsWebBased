<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('profile', function (Blueprint $table) {
            $table->Increments('profile_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->text('address');
            $table->char('phone_no');
            $table->string('email')->unique();
            // $table->unsignedInteger('city_id');
            // $table->foreign('city_id')->references('city_id')->on('city');
            $table->string('permission')->default('customer');
            $table->string('status')->default('active');
            $table->string('passport_no')->unique();
            $table->char('password');
            $table->index(['first_name', 'last_name']);
            $table->index('email');
            $table->index('permission');
            $table->index('status');
            $table->index('passport_no');
            $table->rememberToken();
            $table->timestamps();

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
        Schema::dropIfExists('profile');
    }
}
