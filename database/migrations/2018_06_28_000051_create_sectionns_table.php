<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sectionns', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('appraisal_id')->nullable();
            $table->string('ed_comment')->nullable();
            $table->string('ed_name')->nullable();
            $table->string('ed_initials')->nullable();
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
        Schema::dropIfExists('sectionns');
    }
}
