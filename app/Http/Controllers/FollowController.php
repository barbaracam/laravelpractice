<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;


class FollowController extends Controller{
    
    public function createFollow(User $user){
        //You cannot follow yourself
        if($user->id==auth()->user()->id){
            return back()->with('failed',"You cannot follow yourself" );
        } 
        //You cannot follow somebody twice
        //We create a variabe to check existance in this case $existcheck, then use the follow:: class and the method of where and count to check and count if it is a case like that already existant
        //where says if the user id match the user you log in,or  followed user find the user id want to follow
         $existCheck = Follow::where([['user_id', '=', auth()->user()->id],['followeduser', '=', $user->id]])->count();

         if($existCheck){
            return back()->with("failed", "You are already following that account");
         }
       
        //creating a new route in the database
        $newFollow = new Follow;
        $newFollow->user_id=auth()->user()->id;
        //followed id is the person being follow
        $newFollow->followeduser = $user->id;
        $newFollow->save();

        return back()->with("success", "User succesfully followed");
    }

    //
    public function removeFollow(User $user){
        Follow::where([['user_id', '=', auth()->user()->id],['followeduser', '=', $user->id]])->delete();
        return back()->with('success', "User succesfully unfollowed");
    }
}
