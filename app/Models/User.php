<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    protected function avatar(): Attribute{
        return Attribute::make(get: function($value){
            return $value ? '/storage/avatars/'.$value :'/fallback-avatar.jpg';
        });
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // this is from the perspective who is following us, no who we follow
    //we need to look for the second parameter the key from the perspective of the user, the third is the local key
    public function followers() {
        return $this->hasMany(Follow::class,'followeduser', 'id');
    }

    public function followingTheseUsers() {
        return $this->hasMany(Follow::class,'user_id', 'id');
    }
    public function posts() {
        return $this->hasMany(Post::class,'user_id');
    }

    public function feedPosts() {
        // 1 final model we want to access,2 intermediate table to lookout, 3 foreign key for the intermediate table(2), 4 the foreign key for the first parameter, 5 local key final model(post), 6 local key for intermediate table
        return $this->hasManyThrough(Post::class, Follow::class,'user_id', 'user_id', 'id', 'followeduser' );
    }
}
