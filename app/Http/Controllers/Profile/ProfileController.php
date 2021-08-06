<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FriendShips;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $my_profile = false;


    public function index()
    {
        $userData = Profile::with('user')->get();

        // if ($userData){
        //     $this->my_profile = (auth()->id() == $this->user->id)?true:false;
        //     if (!$this->my_profile){
        //         return false;
        //     }
        //     return true;
        // }

        return response()->json(['data' => $userData]);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }

    public function findFriends(){
        $user_id = auth()->user()->id;
        $all_user = Profile::with('user')->get();
        return response()->json(['data' => $all_user , 'id' => $user_id]);
    }

    public function following(Request $request){

        $user = User::all();

        $list = $user->following()->where('allow', 1)->with('following')->get();

        $my_profile = $this->my_profile;

        $can_see = ($my_profile)?true:$user->canSeeProfile(auth()->user()->id);

        return response()->json(['data' => $list]);
    
    }


    public function followers(Request $request, $username){


        $user = User::all();

        $list = $user->follower()->where('allow', 1)->with('follower')->get();

        $my_profile = $this->my_profile;

        $can_see = ($my_profile)?true:$user->canSeeProfile(auth()->user()->id);

        return response()->json(['data' => $list]);
    }


    
}
