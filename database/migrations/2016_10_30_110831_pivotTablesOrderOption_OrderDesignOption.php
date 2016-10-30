<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PivotTablesOrderOptionOrderDesignOption extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('option_order', function(Blueprint $table) {
            $table->integer('order_id')->unsigned();
            $table->integer('option_id')->unsigned();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('option_id')->references('id')->on('options')->onDelete('restrict')->onUpdate('cascade');
        });

        Schema::create('design_option_order', function(Blueprint $table) {
            $table->integer('order_id')->unsigned();
            $table->integer('design_option_id')->unsigned();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('design_option_id')->references('id')->on('design_options')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('option_order');
        Schema::drop('design_option_order');
    }
}
