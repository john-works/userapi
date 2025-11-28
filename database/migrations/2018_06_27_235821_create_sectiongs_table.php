<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectiongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sectiongs', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('appraisal_id')->nullable();

            $table->string(('recommendation_decision'))->nullable();
            $table->string(('comment'))->nullable();

           /* $table->string(('to_confirm_in_service'))->nullable();
            $table->string(('to_not_to_confirm_in_service'))->nullable();
            $table->string(('to_renew_contract'))->nullable();
            $table->string(('to_not_renew_contract'))->nullable();
            $table->string(('training'))->nullable();
            $table->string(('transfer'))->nullable();
            $table->string(('regrading'))->nullable();
            $table->string(('termination_of_service'))->nullable();
            $table->string(('probationary_period_comments'))->nullable();
            $table->string(('others'))->nullable();*/
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
        Schema::dropIfExists('sectiongs');
    }
}
