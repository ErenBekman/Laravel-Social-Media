<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function __invoke(){
        
    }

    public function index()
    {
        $posts= Post::with('user','comment')->where('user_id' , auth()->user()->id)->orderBy('created_at','DESC')->get();
        return response()->json(['data' => $posts]);
    }

    // public function friendship(){
    //     $friendPost = Post::with('user')->orderBy('created_at' , 'DESC')->get();
    //     // $friendPost = User::with('friendship')->orderBy('created_at' , 'DESC')->get();
    //     return response()->json(['data' => $friendPost]);
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $post = Post::create([
        //     'description' => $request->description,
        //   ]);
            
        // $post = Post::create($request->all());
        // return response()->json($post);
          
        // return Post::create([
        //     'description' => $request['description']
        //  ]);

        

        $request->validate([
            'description' => ['required']
        ]);


 
        $post =  Post::create([
            'description' =>  $request->input('description'),
            'user_id' => auth()->user()->id,
            'created_at' =>\Carbon\Carbon::now()->toDateTimeString(), 
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
         ]);


        return response()->json(['data' => $post]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request , $id , Post $post)
    {
        $post = Post::findOrFail($id);

        $post->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post , $id)
    {
        $deletePost = Post::destroy($id);
        if($deletePost){
            return Post::with('user','comments')
            ->orderBy('created_at','DESC')->get();
          }
        return response()->json("ok");

        // $post = Post::findOrFail($id);
        // $post->delete();
    }

    // public function createPost(Request $request){
    //     $file = $request->file('image_url');
    //     $originalName = $file->getClientOriginalName();
    //     $extension = $file->getClientOriginalExtension();

    //     $path = 'upload/'.uniqid().'.'.$extension;
    //     $img = Image::make($file)->insert(public_path('logo.jpg'));
    //     $img->save(public_path($path));

    //     $input->$request->all();
    //     $input['image_url'] = $path;

    //     return $this->create($input);
    // }
    public function createPost(Request $request , Post $post){
        $files = $request->files('images');
        foreach($files as $file)
        {
            $post->addMedia($file)->toMediaCollection('images');
        }
        return $this->create($input);
    }

 
     public function addComment(Request $request){
         $comment = $request->comment;
         $id = $request->id;

        $createComment = Post::create([
            'comment' => $comment,
            'user_id' => auth()->user()->id,
            'posts_id' => $id,
            'created_at' =>\Carbon\Carbon::now()->toDateTimeString()
        ]);
 
       if($createComment){
         return Post::with('user','likes','comments')->orderBy('created_at','DESC')->get();
       }
   }

   public function like(Request $request){

    $user = auth()->user();
    $response = array();
    $response['code'] = 400;

        $post = Post::find($request->input('id'));

        if ($post){
            $post_like = PostLike::where('post_id', $post->id)->where('like_user_id', $user->id)->get()->first();

            if ($post_like) { // UnLike
                if ($post_like->like_user_id == $user->id) {
                    $deleted = DB::delete('delete from post_likes where post_id='.$post_like->post_id.' and like_user_id='.$post_like->like_user_id);
                    if ($deleted){
                        $response['code'] = 200;
                        $response['type'] = 'unlike';
                    }
                }
            }else{
                // Like
                $post_like = new PostLike();
                $post_like->post_id = $post->id;
                $post_like->like_user_id = $user->id;
                if ($post_like->save()){
                    $response['code'] = 200;
                    $response['type'] = 'like';
                }
            }
            if ($response['code'] == 200){
                $response['like_count'] = $post->getLikeCount();
            }
        }

        return Response::json($response);

   }

   public function img_update(Request $request)
   {
    $user = auth()->user();
    $img = $request->file('images');
    $user->addMedia($img)->toMediaCollection('images');
   }
}
