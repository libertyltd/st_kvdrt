<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->nullable();
            $table->string('email', 255);
            $table->string('theme', 255)->nullable();
            $table->text('message')->nullable();
            $table->string('address', 255)->nullable();
            $table->string('apartments_type', 255)->nullable();
            $table->decimal('apartments_square')->nullable();
            $table->integer('type_building_id')->unsigned()->nullable()->default(null);
            $table->integer('type_bathroom_id')->unsigned()->nullable()->default(null);
            $table->integer('design_id')->unsigned()->nullable()->default(null);
            $table->string('phone')->nullable()->default(null);
            $table->boolean('status')->default(false);

            $table->foreign('type_building_id')->references('id')->on('type_buildings')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('type_bathroom_id')->references('id')->on('type_bathrooms')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('design_id')->references('id')->on('designs')->onDelete('restrict')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
    }
}
