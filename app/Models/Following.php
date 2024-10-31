<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Following extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable =['user_id,following_user_id'];
    protected $table = 'following';

    public  function userfollowing (){
     return  $this->belongsTo(User::class,"user_id");
    }
    public  function userfollower (){
     return  $this->belongsTo(User::class,"user_id");
    }
}
