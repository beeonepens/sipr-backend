<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room', function (Blueprint $table) {
            $table->increments('id_room');
            $table->string('name_room');
            $table->text('description');
            $table->boolean('isOnline');
            $table->boolean('isBooked')->default(false);
            $table->timestamps();

        });

        Schema::table('room', function (Blueprint $table) {
            $table->string('user_id')->nullable();
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
        Schema::dropIfExists('room');
    }
}
