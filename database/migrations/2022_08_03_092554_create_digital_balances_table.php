<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDigitalBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('digital_balances', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // can be default or random
            $table->string('wallet_name');
            $table->string('wallet_id');
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
        Schema::dropIfExists('digital_balances');
    }
}
