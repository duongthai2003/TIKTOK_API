<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id'); // id người gửi
            $table->unsignedBigInteger('receiver_id'); // id người nhận
            $table->text('message');
            $table->bigInteger ('group_chat_id'); 
            $table->timestamps(); 
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
            //tạo khóa ngoại đến bảng user
            //onDelete('cascade'): Nếu một bản ghi trong bảng users bị xóa, tất cả các bản ghi liên quan trong bảng hiện tại (chứa sender_id) cũng sẽ bị xóa theo.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
