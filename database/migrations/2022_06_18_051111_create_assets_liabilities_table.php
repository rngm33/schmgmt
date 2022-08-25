<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsLiabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets_liabilities', function (Blueprint $table) {
            $table->id();
            $table->string('type'); //can be assets or liabilities
            $table->string('topic');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('assets_type')->nullable(true);
            $table->foreign('assets_type')->references('id')->on('assets'); // 1 for current,2 for fixed, 3 for tangible and 4 for intangible
            /*$table->unsignedBigInteger('liabilities_type')->nullable(true);
            $table->foreign('liabilities_type')->references('id')->on('liabilities');*/ // 1 for current,2 for long-term and 3 for contigent
            $table->string('amount');
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
        Schema::dropIfExists('assets_liabilities');
    }
}
