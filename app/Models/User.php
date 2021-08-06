<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Laravel\Sanctum\HasApiTokens;
use Multicaret\Acquaintances\Traits\Friendable;
use App\Models\Post;
use App\Models\Event;
use App\Models\Message;
use App\Models\Conversation;
use App\Models\Role;
use App\Models\Comment;
use App\Models\Profile;
use App\Models\FriendShips;
use App\Models\UserFollowing;



class User extends Authenticatable implements HasMedia
{
    // use HasFactory;
    use Notifiable,HasApiTokens ,InteractsWithMedia , Friendable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'image',
        'role',
        'about',
        'dob',
        'isActive',
        'isPrivate',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    protected $appends = ['avatar'];
    
    public function getAvatarAttribute(){
        $profile = $this->getMedia('avatar')->first();

        if($profile){
            return $profile->getUrl();
        }

        return null;
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    
    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'conversation_user', 'user_id', 'conversation_id');
    }

    public function messages()
    {
        return $this->conversations()->with('messages');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function profile(){
        return $this->hasOne(Profile::class);
    }

    public function friendship(){
        return $this->belongsToMany(FriendShips::class , 'friendships_user' , 'user_id' , 'friend_id');
    }

    public function follower(){
        return $this->hasMany(UserFollowing::class, 'following_user_id', 'id');
    }

    public function following(){
        return $this->hasMany(UserFollowing::class, 'follower_user_id', 'id');
    }

    public function get_profile_photo()
    {
        $this->getMedia('avatar')->first()->getUrl();
    }

    public function add_profile_wallpaper_photo($pathToFile)
    {
        $this->addMedia($pathToFile)->toMediaCollection('wallpaper');
    }

    public function get_profile_wallpaper_photo()
    {
        $this->getMedia('wallpaper')->first()->getUrl();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')->singleFile();
        $this->addMediaCollection('wallpaper')->singleFile();
    }


}
