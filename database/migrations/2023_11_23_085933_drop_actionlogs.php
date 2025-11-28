<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropActionlogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('actionlogs');
        Schema::dropIfExists('statusupdates');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('actionlogs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('required_action');
            $table->string('responsible_department');
            $table->string('responsible_person');
            $table->string('created_by');
            $table->timestamps();
        });

        Schema::create('statusupdates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('actionlog_id');
            $table->string('currently_responsible_person');
            $table->string('updates');
            $table->string('status');
            $table->date('next_action_date');
            $table->string('created_by');
            $table->timestamps();
        });
    }
}
