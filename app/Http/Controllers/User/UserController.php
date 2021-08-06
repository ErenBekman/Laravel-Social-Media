<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Flash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return $users;
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=> ['required'],
            'email'=> ['required'],
            'password'=> ['required'],
            'image'=> ['required'],
            'role'=> ['required'],
            'about'=> ['required'],
            'dob'=> ['required'],
            'isActive'=> ['required'],
            'isPrivate'=> ['required'],
        ]);

        $user = User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> bcrypt($request->password),
            'image'=> $request->image,
            'role'=> $request->role,
            'about'=> $request->about,
            'dob'=> $request->dob,
            'isActive'=> $request->isActive,
            'isPrivate'=> $request->isPrivate,
        ]);
        return response()->json(['data' => $user]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $user = User::find($id);

        return response()->json(['data' => $user]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user = $user->update($request->all() , $id);
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user = $user->delete($id);

    }

    // public function friendship(){
    //     // $friendPost = Post::with('user')->orderBy('created_at' , 'DESC')->get();
    //     $friendPost = User::with('friendship')->orderBy('created_at' , 'DESC')->get();
    //     return response()->json(['data' => $friendPost]);
    // }

    public function avatar_update(Request $request)
    {
     $user = auth()->user();
     if ($request->hasFile('avatar')) 
     {
        $avatar = $request->file('avatar');
        $user->addMedia($avatar)->toMediaCollection('avatar');
     }
     
    }

    public function wallpaper_update(Request $request)
    {
     $user = auth()->user();
     $wall = $request->file('wallpaper');
     $user->addMedia($wall)->toMediaCollection('wallpaper');
    }
}
