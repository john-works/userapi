<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkflowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('workflows', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('appraisal_id');
            $table->integer('supervisor_id')->nullable();
            $table->boolean('supervisor_approval')->default(0)->nullable();
            $table->integer('hod_id')->nullable();
            $table->boolean('hod_approval')->default(0)->nullable();
            $table->integer('executive_director_id')->nullable();
            $table->boolean('executive_director_approval')->default(0)->nullable();
            $table->boolean('supervisor_decision')->nullable();
            $table->boolean('hod_decision')->nullable();
            $table->boolean('executive_director_decision')->nullable();
            $table->string('supervisor_rejection_reason')->nullable();
            $table->string('hod_rejection_reason')->nullable();
            $table->string('executive_director_rejection_reason')->nullable();
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
        Schema::dropIfExists('workflows');
    }
}
