<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdditionalAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additional_assignments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('appraisal_id');
            $table->string('expected_output')->nullable();
            $table->string('actual_performance')->nullable();
            $table->string('maximum_rating')->nullable();
            $table->string('appraisee_rating')->nullable();
            $table->string('appraiser_rating')->nullable();
            $table->string('agreed_rating')->nullable();
            $table->string('form_field_count')->nullable();
            $table->string('objective_code')->nullable();
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
        Schema::dropIfExists('additional_assignments');
    }
}
