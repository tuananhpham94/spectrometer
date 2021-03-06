<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScannedItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scanned_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('spectrometer_id')->unsigned();
            $table->foreign('spectrometer_id')->references('id')->on('spectrometers');
            $table->string('image');
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
        Schema::dropIfExists('scanned_items');
    }
}
