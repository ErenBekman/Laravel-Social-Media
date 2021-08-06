<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFollowingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('user_followings')) {
        Schema::create('user_followings', function (Blueprint $table) {
            $table->id();
            $table->integer('following_user_id')->unsigned();
            $table->integer('follower_user_id')->unsigned();
            $table->boolean('allow')->default(0);

            $table->foreign('following_user_id')
                ->references('id')->on('users')->onDelete("CASCADE");

            $table->foreign('follower_user_id')
                ->references('id')->on('users')->onDelete("CASCADE");
            $table->timestamps();
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

        Schema::table('user_followings', function (Blueprint $table) {
            $table->dropForeign(['following_user_id']);
            $table->dropForeign(['follower_user_id']);
        });

        Schema::table('user_followings', function (Blueprint $table) {
            $table->dropColumn('following_user_id');
            $table->dropColumn('follower_user_id');
        });

        Schema::dropIfExists('user_followings');
    }
}
