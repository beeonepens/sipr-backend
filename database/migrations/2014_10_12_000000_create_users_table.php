<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->unsignedInteger('nip');
            $table->string('name');
            $table->enum('role',['admin','user']);
            $table->boolean('isActive')->default(true);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('avatarUrl')->nullable();
            $table->string('address')->nullable();
            $table->enum('gender',['pria','wanita'])->nullable();
            $table->date('dateofbirth')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->primary('nip');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
