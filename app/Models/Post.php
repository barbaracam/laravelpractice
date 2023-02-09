<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use Searchable;
    use HasFactory;

    protected $fillable = ['title', 'body', 'user_id'];

    //Need to be call exactly same name this function
    public function toSearchableArray(){
        return [
            'title' => $this->title,
            'body' => $this->body
        ];
    }

    //create table association, the first is() the class belongs to and the second is the relationship is power by
    //you can name how you like it even pizza,  
    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }
}
