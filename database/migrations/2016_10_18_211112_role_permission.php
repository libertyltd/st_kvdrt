<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RolePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_permission', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->increments('rp_id');
            $table->string('rp_role_name', 255);
            $table->string('rp_entity_name', 255);
            $table->enum('rp_action', ['add', 'edit', 'view', 'delete', 'create', 'list']);

            $table->foreign('rp_role_name')->references('name_role')->on('role')->onUpdate('restrict')->onDelete('restrict');
        });

        DB::table ('role_permission')->
        insert([
            ['rp_role_name'=>'Administrator', 'rp_entity_name'=>'App\RolePermission', 'rp_action'=>'add'],
            ['rp_role_name'=>'Administrator', 'rp_entity_name'=>'App\RolePermission', 'rp_action'=>'edit'],
            ['rp_role_name'=>'Administrator', 'rp_entity_name'=>'App\RolePermission', 'rp_action'=>'view'],
            ['rp_role_name'=>'Administrator', 'rp_entity_name'=>'App\RolePermission', 'rp_action'=>'delete'],
            ['rp_role_name'=>'Administrator', 'rp_entity_name'=>'App\RolePermission', 'rp_action'=>'list']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('role_permission');
    }
}
