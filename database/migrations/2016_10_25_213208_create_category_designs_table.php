<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryDesignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_designs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_design')->unsigned();
            $table->string('name', 255);

            $table->foreign('id_design')->references('id')->on('designs')->onDelete('cascade')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('category_designs');
    }
}
