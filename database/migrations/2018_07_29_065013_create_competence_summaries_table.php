<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetenceSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competence_summaries', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('appraisal_id')->nullable();
            $table->string('max_rating')->nullable();
            $table->string('appraisee_rating')->nullable();
            $table->string('appraiser_rating')->nullable();
            $table->string('agreed_rating')->nullable();
            $table->string('section_e_percentage_score')->nullable();
            $table->string('section_e_weighed_score')->nullable();

            $table->string('section_e_final_score')->nullable();
            $table->string('section_d_final_score')->nullable();
            $table->string('total_score')->nullable();

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
        Schema::dropIfExists('competence_summaries');
    }
}
