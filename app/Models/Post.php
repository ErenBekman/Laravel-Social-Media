<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Models\User;
use App\Models\Comment;
use App\Models\Media;
use App\Models\PostLike;


class Post extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia;

    protected $fillable = [
        'description','likes','time','is_follow','is_liked','user_id'
    ];
    // protected $guarded = [];

    private $like_count = null;
    private $comment_count = null;

    protected $appends = ['comments'];

    public function getCommentsAttribute(){
        return [];
    }

    public function user(){
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }

    public function comment(){
        return $this->hasMany(Comment::class , 'post_id');
    }

    // public function images()
    // {
    //     return $this->belongsToMany(Media::class, 'post_media', 'post_id', 'media_id');
    // }

    public function users_posts()
    {
        return $this->belongsToMany(User::class, 'posts', 'id', 'user_id');
    }

    public function postsLiked()
    {
        $result = DB::table('post_likes')->get();
        return $result;
    }

    public function postShared()
    {
        $result = DB::table('post_shares')->get();
        return $result;
    }

    public function likes(){
        return $this->hasMany(PostLike::class ,'post_id', 'id');
    }

    public function getLikeCount(){
        if ($this->like_count == null){
            $this->like_count = $this->likes()->count();
        }
        return $this->like_count;
    }

    public function getCommentCount(){
        if ($this->comment_count == null){
            $this->comment_count = $this->comment()->count();
        }
        return $this->comment_count;
    }

    public function add_img($pathToFile)
    {
        $this->addMedia($pathToFile)->toMediaCollection('images');
    }

    public function get_img()
    {
        $this->getMedia('images')->first()->getUrl();
    }

}
