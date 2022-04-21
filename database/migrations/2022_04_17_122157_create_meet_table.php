<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meet', function (Blueprint $table) {
            $table->increments('id_meet');
            $table->string('name_meeting');
            $table->text('description');
            $table->boolean('isOnline');
            $table->integer('limit')->default(1);
            $table->timestamps();

        });

        Schema::table('meet', function (Blueprint $table) {
            $table->unsignedInteger('room_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();

            $table->foreign('room_id')
                    ->references('id_room')
                    ->on('room')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');;


            $table->foreign('user_id')
                    ->references('nip')
                    ->on('users')
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
        Schema::dropIfExists('meet');
    }
}
