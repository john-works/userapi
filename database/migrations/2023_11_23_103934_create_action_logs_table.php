<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('action_logs')){
            Schema::create('action_logs', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('department_id');
                $table->string('actionlog_type');
                $table->string('required_action');
                $table->string('responsible_person');
                $table->string('status');
                $table->string('completion_user')->nullable();
                $table->timestamp('completion_datetime')->nullable();
                $table->string('completion_comment')->nullable();
                $table->string('created_by');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('action_logs');
    }
}
