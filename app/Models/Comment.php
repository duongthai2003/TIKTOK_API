<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable=[
        'content',
        'like_count',
        'id_user',
        'id_video',
    ];

    protected $table = 'comment';

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

}
