<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddAssignmentsSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('add_assignments_summaries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('appraisal_id')->nullable();
            $table->string('max_rating')->nullable();
            $table->string('appraisee_rating')->nullable();
            $table->string('appraiser_rating')->nullable();
            $table->string('agreed_rating')->nullable();
            $table->string('section_d_percentage_score')->nullable();
            $table->string('section_d_weighed_score')->nullable();
            $table->string('appraiser_comment')->nullable();
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
        Schema::dropIfExists('add_assignments_summaries');
    }
}
