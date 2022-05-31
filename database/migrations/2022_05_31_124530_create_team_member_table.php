<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_member', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_team');
            $table->string('id_member');
            $table->timestamps();

            $table->foreign('id_team')->references('id_team')->on('teams');
            $table->foreign('id_member')->references('nip')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_member');
    }
}
