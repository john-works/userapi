<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToActionLogTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('action_log_tasks', function (Blueprint $table) {
            $table->string('status')->nullable();
            $table->string('completion_user')->nullable();
            $table->timestamp('completion_datetime')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('action_log_tasks', function (Blueprint $table) {
            $table->dropColumn(['status','completion_user','completion_datetime']);
        });
    }
}
