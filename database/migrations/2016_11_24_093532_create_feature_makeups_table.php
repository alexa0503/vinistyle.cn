<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeatureMakeupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feature_makeups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('feature_id')->index()->unsigned();
            $table->foreign('feature_id')->references('id')->on('features');
            $table->integer('makeup_id')->index()->unsigned();
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
        Schema::dropIfExists('feature_makeups');
    }
}
