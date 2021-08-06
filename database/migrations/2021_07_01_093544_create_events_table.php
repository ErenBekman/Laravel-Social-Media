<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('calendarId');
            $table->string('title');
            $table->string('body');
            $table->boolean('isAllday');
            $table->time('start');
            $table->time('end');
            $table->string('category');
            $table->string('dueDateClass');
            $table->string('color');
            $table->string('bgColor');
            $table->string('dragBgColor');
            $table->string('borderColor');
            $table->string('customStyle');
            $table->boolean('isFocused');
            $table->boolean('isPending');
            $table->boolean('isVisible');
            $table->boolean('isReadOnly');
            $table->string('goingDuration');
            $table->string('comingDuration');
            $table->string('recurrenceRule');
            $table->string('state');
            $table->json('raw');
            $table->boolean('isPrivate');
            $table->string('location');
            $table->json('attendees');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
