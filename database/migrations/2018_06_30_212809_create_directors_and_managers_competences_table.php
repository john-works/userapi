<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDirectorsAndManagersCompetencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directors_and_managers_competences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('appraisal_id')->nullable();
            $table->string('competence_count')->nullable();
            $table->string('competence')->nullable();
            $table->string('category')->nullable();
            $table->string('max_rating')->nullable();
            $table->string('appraisee_rating')->nullable();
            $table->string('appraiser_rating')->nullable();
            $table->string('agreed_rating')->nullable();
            $table->string('record_count')->nullable();
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
        Schema::dropIfExists('directors_and_managers_competences');
    }
}
