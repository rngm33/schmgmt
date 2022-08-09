<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_balances', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // can be default or random
            $table->string('bank_name');
            $table->string('account_no');
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('description')->nullable();
            $table->string('amount')->nullable();
            $table->string('date_np',10);
            $table->string('date',10);
            $table->string('time',8);
            $table->boolean('is_active')->default(True);
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('bank_balances');
    }
}
