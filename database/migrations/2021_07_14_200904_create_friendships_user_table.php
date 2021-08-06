<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFriendshipsUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('friendships_user')) {
            Schema::create('friendships_user', function (Blueprint $table) {
                $table->id();
                $table->integer('user_id')->unsigned();
                $table->integer('friend_id')->unsigned();
                $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
                $table->foreign('friend_id')->references('id')->on('roles')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
                $table->primary(['user_id', 'friend_id']);
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
        Schema::table('friendships_user', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['friend_id']);
        });

        Schema::table('friendships_user', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('friend_id');
        });
        Schema::dropIfExists('friendships_user');
    }
}
