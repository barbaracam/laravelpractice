<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //validate to allow form to process
    public function register (Request $request){
        $incomingFields=$request->validate([
            //rule first go the table, second argument name of field
            //rick click rule select  validation rule
            'username' => ['required','min:3', 'max:20', Rule::unique('users' ,'username')],
            'email' => ['required','email',Rule::unique('users', 'email')],
            'password'=> ['required', 'min:8', 'confirmed']
        ]);
        //modify password hash
        $incomingFields['password'] = bcrypt($incomingFields['password']);

        //store in the database
        //right click user and import class, this line is mean we adding the info in the database and will return the info of that user, thats why we create variable $user
        $user = User::create($incomingFields);

        //lets auth before redirect to the website
        auth()->login($user);
        return redirect('/')->with('success', 'Thank you for register');
        // return 'Hello from registration';
    }
    // function to login
    public function login (Request $request){
        $incomingFields=$request->validate([
            'loginusername' => 'required',
            'loginpassword' => 'required'
        ]);
        //attempt is the new information login and will match with out(info the database)
        //oath is a globally helper fuction for authorization that give an object
        if(auth()->attempt(['username'=> $incomingFields['loginusername'], 'password'=> $incomingFields['loginpassword']])){
            // this method regenerate keep a cookie
            $request->session()->regenerate();
            // return 'You are a person';
            //redirect with the method with, adding following message (name of message,"message info )
            return redirect('/')->with('success', "you succefully sign in");
        }else{
            return redirect('/')->with('failed', 'you dont have the right credentials');
            // return 'you are a virus';
        }
    }
    //Take the user to the right page if the password is correct is not go back to the homepage
    public function showCorrectHomepage(){
        //this method call check will provide true or false
        if(auth()->check()){
            return view('homepage-feed');
        }else {
            return view('homepage');
        }
    }
    //function to logout
    public function logout(){
        //call logout method
        auth()->logout();
        // return 'You are now logged out';
        return redirect('/')->with('success', "you are log out");

    }
    //function for profile
    //build the methaphore user and the 2 match the parameter router
    public function profile(User $usuario) {
        // this word posts() come from the user model, the function posts
        // return $usuario->posts()->get();
        //latest(0 come from the newest on top)
        //the last one in the array is to get the number of post by client
        return view('profile-posts', ['username' => $usuario->username,'posts'=>$usuario->posts()->latest()->get(), 'postCount'=> $usuario->posts()->count()]);
    }
}
