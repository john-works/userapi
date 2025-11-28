<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoggerAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('logger_admins')){
            Schema::create('logger_admins', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('department_id');
                $table->string('user_id');
                $table->foreign('department_id')->references('id')->on('departments');
                $table->foreign('user_id')->references('username')->on('users');
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
        Schema::dropIfExists('logger_admins');
    }
}
