<?php

namespace App\Http\Controllers\Follow;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class FollowController extends Controller
{
    public function follow(Request $request){

        $response = array();
        $response['code'] = 400;

        $following_user_id = $request->input('following');
        $follower_user_id = $request->input('follower');

        $following = User::find($following_user_id);
        $follower = User::find($follower_user_id);

        if ($following && $follower && ($following_user_id == auth()->id() || $follower_user_id == auth()->id())){

            $relation = UserFollowing::where('following_user_id', $following_user_id)->where('follower_user_id', $follower_user_id)->get()->first();

            if ($relation){
                if ($relation->delete()){
                    $response['code'] = 200;
                    if ($following->isPrivate()) {
                        $response['refresh'] = 1;
                    }
                }
            }else{
                $relation = new UserFollowing();
                $relation->following_user_id = $following_user_id;
                $relation->follower_user_id = $follower_user_id;
                if ($following->isPrivate()){
                    $relation->allow = 0;
                }else{
                    $relation->allow = 1;
                }
                if ($relation->save()){
                    $response['code'] = 200;
                    $response['refresh'] = 0;
                }
            }
        }
        return response()->json(['data' => $response]);  
    }

    public function followerRequest(Request $request){

        $response = array();
        $response['code'] = 400;

        $following = UserFollowing::find($id);

        if ($following){
            if ($following->following_user_id = auth()->id()){
                if ($type == 2){
                    if ($following->delete()){
                        $response['code'] = 200;
                    }
                }else{
                    $following->allow = 1;
                    if ($following->save()){
                        $response['code'] = 200;
                    }
                }
            }
        }
        return response()->json(['data' => $response]);
    }

    public function followDenied(Request $request){

        $response = array();
        $response['code'] = 400;

        $me = $request->input('me');
        $follower = $request->input('follower');

        $relation = UserFollowing::where('following_user_id', $me)->where('follower_user_id', $follower)->get()->first();

        if ($relation){
            if ($relation->delete()){
                $response['code'] = 200;
            }
        }
        return response()->json(['data' => $response]);
    }


    public function pending(Request $request){

        $user = auth()->user();

        $list = $user->follower()->where('allow', 0)->with('follower')->get();

        return response()->json(['data' => $list]);
    }
}
