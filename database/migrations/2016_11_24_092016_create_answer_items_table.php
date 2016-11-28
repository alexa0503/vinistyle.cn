<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswerItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answer_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('answer_id')->index()->unsigned();
            $table->integer('question_id')->index()->unsigned();
            $table->foreign('question_id')->references('id')->on('questions');
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
        Schema::dropIfExists('answer_items');
    }
}
