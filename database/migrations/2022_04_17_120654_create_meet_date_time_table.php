<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetDateTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meet_date_time', function (Blueprint $table) {
            $table->increments('id');

            $table->string('datetime');

            //$table->primary('datetime');
        });
        Schema::table('meet_date_time', function (Blueprint $table) {
            $table->unsignedInteger('id_meet');
            $table->foreign('id_meet')
                    ->references('id_meet')
                    ->on('meet')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meet_date_time');
    }
}
