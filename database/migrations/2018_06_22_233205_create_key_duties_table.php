<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeyDutiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('key_duties', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('appraisal_id');
            $table->string('objective_code')->nullable();
            $table->string('job_assignment')->nullable();
            $table->string('expected_output')->nullable();
            $table->string('maximum_rating')->nullable();
            $table->string('time_frame')->nullable();
            $table->string('form_field_count')->nullable();
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
        Schema::dropIfExists('key_duties');
    }
}
