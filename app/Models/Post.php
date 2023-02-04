<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'user_id'];

    //create table association, the first is() the class belongs to and the second is the relationship is power by
    //you can name how you like it even pizza,  
    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }
}
