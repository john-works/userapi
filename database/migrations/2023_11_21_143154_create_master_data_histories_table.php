<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterDataHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hastable('master_data_histories')){
            Schema::create('master_data_histories', function (Blueprint $table) {
                $table->increments('id');
                $table->string('parent_master_data_type');
                $table->string('master_data_type');
                $table->string('action_type');
                $table->string('action_user');
                $table->dateTime('action_date');
                $table->boolean('is_json_value')->default(false);
                $table->text('old_value');
                $table->text('new_value');
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
        Schema::dropIfExists('master_data_histories');
    }
}
