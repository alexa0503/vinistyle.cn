<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMakeupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('makeups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pre_img_path',120);
            $table->string('title',120);
            $table->string('sub_title',120);
            $table->string('desc',200);
            $table->string('application',200);
            //$table->text('featured_content');
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
        Schema::dropIfExists('makeups');
    }
}
