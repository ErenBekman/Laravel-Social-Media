<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use App\Models\User;

class PostLike extends Model
{
    use HasFactory;

    protected $table = 'post_likes';
    protected $primaryKey = ['post_id', 'user_id'];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function post(){
        return $this->belongsTo(Post::class, 'post_id');
    }


    public function user(){
        return $this->belongsTo(User::class , 'user_id');
    }


}
