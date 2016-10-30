<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PriceOnASquareAndConstantCYInDesign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('designs', function ($table) {
            $table->decimal('price_square')->default(0);
            $table->decimal('constant_cy')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Shema::table('designs', function ($table) {
            $table->dropColumn('price_square');
            $table->dropColumn('constant_cy');
        });
    }
}
