<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWallpapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('role_user')) {
        Schema::create('wallpapers', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->integer('media_id')->unsigned();
            $table->foreign('media_id')->references('id')->on('media')
            ->onDelete('CASCADE')
            ->onUpdate('CASCADE'); 
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
        Schema::table('wallpapers', function (Blueprint $table) {
            $table->dropForeign('media_id');
        });
        Schema::dropIfExists('wallpapers');
    }
}
