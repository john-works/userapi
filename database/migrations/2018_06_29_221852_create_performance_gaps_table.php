<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerformanceGapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performance_gaps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('appraisal_id')->nullable();
            $table->string('performance')->nullable();
            $table->string('cause')->nullable();
            $table->string('recommendation')->nullable();
            $table->string('when')->nullable();
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
        Schema::dropIfExists('performance_gaps');
    }
}
