<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('isRead')->default(false);
            $table->enum('notification_type', ['notification', 'invitation']);
            $table->string('publicationDate');
            $table->timestamps();

            $table->unsignedInteger('meet_id');
            $table->foreign('meet_id')
                ->references('id_meet')
                ->on('meet')
                ->onUpdate('cascade')
                ->onDelete('cascade');;

            $table->string('user_id');
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
        Schema::dropIfExists('notifications');
    }
}
