<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable=[
        'file_url',
        'img_url',
        'file_format',
        'music',
        'description',
        'like_count',
        'comment_count',
        'share_count',
        'user_id',
    ];
    protected  $table = 'videos';

    public function user(){
        return $this->belongsTo(User::class,'user_id');
        // Cai user_id ko can dien cung dc thang laravel no se tu
        //hieu la user_id anh dien mau thoi
        //nó sẽ tự động lấy cái user_id lm khóa ngoài nối đến khóa chính ' id ' của bảng users


    }

    public function comment(){
        return $this->hasMany(Comment::class);
    }
}
