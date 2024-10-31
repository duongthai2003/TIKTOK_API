<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string ('description')->default("");
            $table->string ('music')->default("");
            $table->string ('file_url');
            $table->string ('img_url')->default("");
            $table->string ('file_format')->default("");
            $table->integer ('like_count')->default(0);
            $table->integer ('comment_count')->default(0);
            $table->integer ('share_count')->default(0);
            $table->bigInteger ('user_id');
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
        Schema::dropIfExists('customer');
    }
}
