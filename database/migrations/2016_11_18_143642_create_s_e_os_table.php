<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSEOsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_e_os', function (Blueprint $table) {
            $table->increments('id');
            $table->string('original_url', 255);
            $table->string('alias_url', 255)->nullable()->default(null);
            $table->string('title', 255)->nullable()->default(null);
            $table->string('keywords', 255)->nullable()->default(null);
            $table->string('description', 255)->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('s_e_os');
    }
}
