<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeatureItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feature_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('feature_id')->index()->unsigned();
            $table->foreign('feature_id')->references('id')->on('features');
            $table->integer('item_id')->index()->unsigned();
            $table->foreign('item_id')->references('id')->on('items');
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
        Schema::dropIfExists('feature_items');
    }
}
