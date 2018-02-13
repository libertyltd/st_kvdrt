<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDesignOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('design_options', function (Blueprint $table) {
            $table->dropColumn('color');
            $table->enum('type', ['bathroom', 'room']);
            $table->string('description', 255);
        });

        Schema::drop('design_option_order');
        Schema::drop('option_order');
        Schema::drop('variable_param_order');

        Schema::create('variable_param_order', function(Blueprint $table) {
            $table->integer('order_id')->unsigned();
            $table->integer('variable_param_id')->unsigned();
            $table->integer('amount')->unsigned()->nullable();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('variable_param_id')->references('id')->on('variable_params')->onDelete('restrict')->onUpdate('cascade');
        });

        Schema::create('option_order', function(Blueprint $table) {
            $table->integer('order_id')->unsigned();
            $table->integer('option_id')->unsigned();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('option_id')->references('id')->on('options')->onDelete('restrict')->onUpdate('cascade');
        });

        Schema::create('design_option_order', function (Blueprint $table) {
            $table->integer('order_id')->unsigned();
            $table->integer('design_option_id')->unsigned();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::table('design_options', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('description');
            $table->string('color', 6);
        });
    }
}
