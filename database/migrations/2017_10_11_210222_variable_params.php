<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VariableParams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variable_params', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->integer('amount_piece')->unsigned();
            $table->float('price_per_one')->unsigned();
            $table->integer('min_amount')->default(0);
            $table->integer('max_amount')->default(0);
            $table->boolean('is_one');
            $table->integer('parent_id')->unsigned()->nullable()->default(null);
            $table->boolean('status')->default(false);

            $table->foreign('parent_id')->references('id')->on('variable_params')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('variable_params');
    }
}
