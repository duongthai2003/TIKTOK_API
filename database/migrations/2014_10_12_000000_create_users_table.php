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
            $table->bigIncrements('id'); //tu tang
            $table->string('name');
            $table->string('nickname');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('avatar')->default(" ");
            $table->string ('public_id_avatar')->default(NULL);
            $table->string('tick')->default("false");
            $table->string('bio')->default("");
            $table->integer('like_counts')->default(0);
            $table->integer('following_counts')->default(0);
            $table->integer('follower_counts')->default(0);
            $table->integer('friend_counts')->default(0);
            $table->string('facebook_url')->default("");
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
