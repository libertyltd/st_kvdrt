<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCoefficientFiledBuildingTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('type_buildings', function ($table) {
            $table->decimal('additional_coefficient')->default(0);
        });
        Schema::table('type_bathrooms', function ($table) {
            $table->decimal('additional_coefficient')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('type_buildings', function($table) {
            $table->dropColumn('additional_coefficient');
        });
        Schema::table('type_bathrooms', function($table) {
            $table->dropColumn('additional_coefficient');
        });
    }
}
