<?php

namespace App\Http\Controllers\Likes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;

class LikesController extends Controller
{
    public function like($id)
    {
        $post = Post::find($id);

        $like =  Like::create([
            'user_id' => auth()->id(),
            'post_id' => $post->id
        ]);

        return Like::find($like->id);
    }

    public function unlike($id)
    {
        $post = Post::find($id);
        
        $like = Like::where('user_id', auth()->id())
            ->where('post_id', $post->id)
            ->first();

        $like->delete();

        return $like->id;
    }
}
