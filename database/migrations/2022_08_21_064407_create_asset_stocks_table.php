<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assets_id')->nullable();
            $table->foreign('assets_id')->references('id')->on('assets');
            $table->string('sub_type');
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
        Schema::dropIfExists('asset_stocks');
    }
}
