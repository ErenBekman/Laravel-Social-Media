<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use App\Models\Wallpaper;

class Media extends Model
{
    use HasFactory;

    protected $table = 'media';

    protected $fillable = ['title', 'type', 'source'];

    public function post()
    {
        return $this->belongsToMany(Post::class, 'post_media', 'media_id', 'post_id');
    }

    public function wallpaper()
    {
        return $this->belongsTo(Wallpaper::class);
    }

}
