<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesignOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('design_options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('color', 6);
            $table->string('name', 255);
            $table->decimal('price');
            $table->integer('category_design_id')->unsigned();
            $table->boolean('status')->default(false);

            $table->foreign('category_design_id')->references('id')->on('category_designs')->onDelete('cascade')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('design_options');
    }
}
