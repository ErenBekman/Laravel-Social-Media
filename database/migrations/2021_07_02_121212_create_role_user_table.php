<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('role_user')) {
        Schema::create('role_user', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
            ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('role_id')->references('id')->on('roles')
            ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->primary(['user_id', 'role_id']);
        });

     }   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('role_user', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['role_id']);
        });

        Schema::table('role_user', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('role_id');
        });

        Schema::dropIfExists('role_user');
    }
}
