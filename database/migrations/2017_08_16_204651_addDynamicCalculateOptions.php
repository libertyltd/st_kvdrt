<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDynamicCalculateOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('options', function ($table) {
            $table->boolean('is_dynamic_calculate')->default(false);
            $table->decimal('price_per_meter')->default(0);
            $table->decimal('minimal_dynamic_price')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('options', function($table) {
            $table->dropColumn('is_dynamic_calculate');
            $table->dropColumn('price_per_meter');
            $table->dropColumn('minimal_dynamic_price');
        });
    }
}
