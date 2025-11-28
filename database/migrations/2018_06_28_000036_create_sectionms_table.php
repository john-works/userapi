<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sectionms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('appraisal_id')->nullable();
            $table->string('appraisee_name')->nullable();
            $table->string('agreed_or_disagree')->nullable();
            $table->string('reason_for_disagree')->nullable();
            $table->string('name')->nullable();
            $table->string('initials')->nullable();
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
        Schema::dropIfExists('sectionms');
    }
}
