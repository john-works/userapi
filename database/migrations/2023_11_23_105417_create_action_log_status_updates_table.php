<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionLogStatusUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('action_log_status_updates')){
            Schema::create('action_log_status_updates', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('actionlog_id');
                $table->string('current_status')->nullable();
                $table->string('next_action_department_name')->nullable();
                $table->string('next_action_department_code')->nullable();
                $table->string('next_action_unit_name')->nullable();
                $table->string('next_action_unit_code')->nullable();
                $table->string('next_action_user')->nullable();
                $table->text('next_action')->nullable();
                $table->date('next_action_date')->nullable();
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
        Schema::dropIfExists('action_log_status_updates');
    }
}
