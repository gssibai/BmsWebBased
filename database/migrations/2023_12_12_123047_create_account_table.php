<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('account', function (Blueprint $table) {
            $table->Increments('account_id');
            $table->decimal('balance');
            $table->enum('account_type', ['savings', 'checking', 'credit'])->comment('ENUM(savings, checking, credit)');
            $table->unsignedInteger('currency_id');
            $table->foreign('currency_id')->references('currency_id')->on('currency');
            $table->unsignedInteger('customer_id');
            $table->foreign('customer_id')->references('customer_id')->on('customer');
            $table->index('account_id');
            $table->index('account_type');
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
        Schema::dropIfExists('account');
    }
}
