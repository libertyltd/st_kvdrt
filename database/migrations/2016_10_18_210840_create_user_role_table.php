<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('name_role', 255)->unique();
        });

        Schema::create('users_role', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integer('user_id')->unsigned();
            $table->string('role_id', 255);


            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('role_id')->references('name_role')->on('role')->onDelete('restrict')->onUpdate('cascade');
        });


        DB::table('role')->insert([
            ['name_role' => 'Administrator'],
            ['name_role' => 'User']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users_role');
        Schema::drop('role');
    }
}
