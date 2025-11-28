<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompletionNoteColumnToActionLogTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('action_log_tasks', function (Blueprint $table) {
            $table->string('completion_note')->nullable()->after('completion_user');
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
            $table->dropColumn(['completion_note']);
        });
    }
}
