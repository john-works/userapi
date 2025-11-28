<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusupdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statusupdates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('actionlog_id');
            $table->string('currently_responsible_person');
            $table->string('updates');
            $table->string('status');
            $table->date('planned_completion_date');
            $table->string('created_by');
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
        Schema::dropIfExists('statusupdates');
    }
}
