<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserFollowing extends Model
{
    use HasFactory;
    protected $fillable = ['following_user_id' , 'follower_user_id' , 'allow'];
    public $timestamps = false;

    public function follower(){
        return $this->belongsTo(User::class, 'follower_user_id');
    }

    public function following(){
        return $this->belongsTo(User::class, 'following_user_id');
    }

    public function getAllow(){
        return $this->allow;
    }

}
