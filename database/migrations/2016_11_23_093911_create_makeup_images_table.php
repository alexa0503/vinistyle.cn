<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMakeupImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('makeup_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 120);
            $table->string('path', 120);
            $table->integer('makeup_id')->index()->unsigned();//->unsigned()
            $table->foreign('makeup_id')->references('id')->on('makeups');
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
        Schema::dropIfExists('makeup_images');
    }
}
