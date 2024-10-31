<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class likevideo extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable =['video_id,user_id'];
    protected $table = 'like_video';

    public function user (){
        return $this->belongsTo(User::class,'user_id');
    }
    public function video (){
        return $this->belongsTo(Video::class,'video_id');
    }
}
