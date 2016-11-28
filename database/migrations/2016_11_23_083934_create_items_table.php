<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pre_img_path',120);
            $table->string('name', 120);
            $table->string('color', 120);
            $table->string('specification', 120);
            $table->decimal('price', 10 ,2);
            $table->integer('type_id')->index()->unsigned();
            $table->foreign('type_id')->references('id')->on('item_types');
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
        Schema::dropIfExists('items');
    }
}
