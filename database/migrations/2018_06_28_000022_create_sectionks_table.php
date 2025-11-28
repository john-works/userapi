<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sectionks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('appraisal_id')->nullable();
            $table->string('hod_comment')->nullable();
            $table->string('hod_name')->nullable();
            $table->string('hod_initials')->nullable();
            $table->date('date')->nullable();
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
        Schema::dropIfExists('sectionks');
    }
}
