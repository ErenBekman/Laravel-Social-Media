<?php

namespace App\Http\Controllers\FriendShips;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class FriendshipsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function befriend(User $friend)
    {
        auth()->user()->befriend($friend);
    }

    public function acceptFriendRequest(User $friend)
    {
        auth()->user()->acceptFriendRequest($friend);
    }

    public function denyFriendRequest(User $friend)
    {
        auth()->user()->denyFriendRequest($friend);
    }


}
