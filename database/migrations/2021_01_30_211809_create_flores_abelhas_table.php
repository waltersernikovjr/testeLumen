<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFloresAbelhasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flores_abelhas', function (Blueprint $table) {
            $table->unsignedInteger('flor_id');
            $table->unsignedInteger('abelha_id');

            $table->foreign('flor_id')->references('id')->on('flores')->onDelete('cascade');
            $table->foreign('abelha_id')->references('id')->on('abelhas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flores_abelhas');
    }
}
