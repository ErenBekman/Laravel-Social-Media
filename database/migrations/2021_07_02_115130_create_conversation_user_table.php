<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversationUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('conversation_user')) {
        Schema::create('conversation_user', function (Blueprint $table) {
            $table->id();
            $table->integer('conversation_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('conversation_id')->references('id')->on('messages')
            ->onDelete('CASCADE')
            ->onUpdate('CASCADE');
            $table->foreign('user_id')->references('id')->on('users')
            ->onDelete('CASCADE')
            ->onUpdate('CASCADE');
            $table->primary(['conversation_id', 'user_id']);
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

   
            Schema::table('conversation_user', function (Blueprint $table) {
                $table->dropForeign('conversation_id');
                $table->dropForeign('user_id');
            });

            Schema::table('conversation_user', function (Blueprint $table) {
                $table->dropColumn('conversation_id');
                $table->dropColumn('user_id');
            });
            
        

    
        Schema::dropIfExists('conversation_user');
    }
}
