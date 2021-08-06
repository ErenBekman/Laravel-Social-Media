<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use App\Models\User;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'comment',
        'user_id',
        'length',
        'is_commentLike',
    ];

    public function post(){
        return $this->belongsTo(Post::class , 'post_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }

    // public function comments_liked()
    // {
    //     return $this->belongsToMany(User::class, 'comment_likes', 'comment_id', 'user_id');
    // }




}
