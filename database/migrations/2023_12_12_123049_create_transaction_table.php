<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('transaction', function (Blueprint $table) {
            $table->Increments('transaction_id');
            $table->decimal('amount')->comment('NOT NULLABLE');
            $table->dateTime('transaction_date');
            $table->enum('transaction_type', ['deposit', 'withdrawal', 'transfer'])->comment('ENUM(deposit, withdrawal, transfer)');
            $table->unsignedInteger('branch_id');
            $table->foreign('branch_id')->references('branch_id')->on('branch');
            $table->decimal('balance');
            $table->unsignedInteger('account_id');
            $table->foreign('account_id')->references('account_id')->on('account');
            $table->text('description')->nullable();
            $table->index('transaction_id');
            $table->index('transaction_date');
            $table->index('transaction_type');
            $table->index('branch_id');
            $table->index('account_id');
            // $table->index('description');
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
        Schema::dropIfExists('transaction');
    }
}
