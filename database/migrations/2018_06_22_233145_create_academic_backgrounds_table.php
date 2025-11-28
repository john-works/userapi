<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcademicBackgroundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academic_backgrounds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('appraisal_id');
            $table->string('school')->nullable();
            $table->string('year')->nullable();
            $table->string('award')->nullable();
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
        Schema::dropIfExists('academic_backgrounds');
    }
}
