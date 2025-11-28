<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppraisalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appraisals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('reference')->nullable();
            $table->string('staff_file_number')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('document_name')->nullable();
            $table->string('surname')->nullable();
            $table->string('other_name')->nullable();
            $table->string('department')->nullable();
            $table->string('designation')->nullable();
            $table->date('dob')->nullable();
            $table->boolean('sectiona_status')->nullable();
            $table->boolean('sectionb_status')->nullable();
            $table->boolean('sectionc_status')->nullable();
            $table->boolean('sectiond_status')->nullable();
            $table->boolean('sectione_status')->nullable();
            $table->boolean('sectionf_status')->nullable();
            $table->boolean('sectiong_status')->nullable();
            $table->boolean('sectionh_status')->nullable();
            $table->boolean('sectioni_status')->nullable();
            $table->boolean('sectionj_status')->nullable();
            $table->boolean('sectionk_status')->nullable();
            $table->boolean('sectionl_status')->nullable();
            $table->boolean('sectionm_status')->nullable();
            $table->boolean('sectionn_status')->nullable();
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
        Schema::dropIfExists('appraisals');
    }
}
