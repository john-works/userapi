<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignmentsSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments_summaries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('appraisal_id')->nullable();
            $table->double('maxRating')->nullable();
            $table->double('appraiseeRating')->nullable();
            $table->double('appraiserRating')->nullable();
            $table->double('agreedRating')->nullable();
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
        Schema::dropIfExists('assignments_summaries');
    }
}
