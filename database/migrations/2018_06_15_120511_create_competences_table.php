<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('appraisal_id');
            $table->string('category_code')->nullable();
            $table->string('competence_code')->nullable();
            $table->string('competence')->nullable();
            $table->string('maximum_rating')->nullable();
            $table->string('appraisee_rating')->nullable();
            $table->string('appraiser_rating')->nullable();
            $table->string('agreed_rating')->nullable();
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
        Schema::dropIfExists('competences');
    }
}
