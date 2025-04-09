<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupChats extends Model
{
    use HasFactory;
    protected $table = 'group_chats';
    public $timestamps = false;
    protected $fillable=[
       "member_1",'member_2','name_group'
    ];

    public function member_2() {
        return $this->belongsTo(User::class,'member_2');
    }
    public function member_1() {
        return $this->belongsTo(User::class,'member_1');
    }
    public function latestMessage()
{
    return $this->hasOne(Message::class, 'group_chat_id')->latest();
}
}
