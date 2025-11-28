<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('calendar_id');
            $table->string('title');
            $table->string('location');
            $table->date('start');
            $table->date('end');
            $table->boolean('isAllDay')->default(false);
            $table->string('category');
            $table->boolean('isPrivate')->default(false);
            $table->boolean('isReadonly')->default(false);
            $table->string('state');
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
