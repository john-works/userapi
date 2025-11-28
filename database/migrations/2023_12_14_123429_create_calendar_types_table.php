<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hastable('calendar_types')){
            Schema::create('calendar_types', function (Blueprint $table) {
                $table->increments('id');
                $table->string('department_code');
                $table->string('department_name');
                $table->string('color');
                $table->string('backgroundColor');
                $table->string('dragBackgroundColor');
                $table->string('borderColor');
                $table->string('calendarView');
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
        Schema::dropIfExists('calendar_type_admins');
    }
}
