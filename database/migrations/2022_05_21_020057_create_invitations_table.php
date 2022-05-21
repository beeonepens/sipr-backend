<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->increments('id_inivitation');
            $table->boolean('isAccepted')->default(false);
            $table->string('reason');
            $table->string('expiredDateTime');
            $table->timestamps();
            $table->string('id_invitee');
            $table->foreign('id_invitee')
                ->references('nip')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('id_receiver');
            $table->foreign('id_receiver')
                ->references('nip')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedInteger('id_meet');
            $table->foreign('id_meet')
                ->references('id_meet')
                ->on('meet')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invitations');
    }
}
