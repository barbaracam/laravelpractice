<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use App\Events\OurExampleEventBarbara;
use Illuminate\Support\Facades\Storage;

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
            //calling an event, import class
            event(new OurExampleEventBarbara(['username'=>auth()->user()->username, 'action'=>'login']));
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
            //instance for the current model for the logged user, call the function from the user model, calling all post from the followers, paginate the number of post allow
            return view('homepage-feed',['posts'=> auth()->user()->feedPosts()->latest()->paginate(2)]);
        }else {
            //cache we can use the post model put,has(check),get cache
            // $postCount = Cache::put
            //lets comment this to do a easier form

            //if(Cache::has('postCount')){
            //  $postCount = Cache::get('postCount');
            //} else {                
                //we create a variable with the post count, added in a cache
                //store in the cache put first label or key of the data, second it is the actual value, 3 time
             // sleep(5); dont do this is for checking only 
            // $postCount = Post::count();                
            // Cache::put('postCount', $postCount, 45);
            //}

            //easier way for cache, the 3 will be a function if it is not cache existing
            $postCount = Cache::remember('postCount',45 ,function(){
                sleep(5);
                return Post::count();
            });

            // return view('homepage', ['postCount'=>Post::count()]);
            //changed becase we want to change to dinamic way
            return view('homepage', ['postCount'=>$postCount]);
        }
    }
    //function to logout
    public function logout(){
          //calling an event, import class
        event(new OurExampleEventBarbara(['username'=>auth()->user()->username, 'action'=>'logout']));
        //call logout method
        auth()->logout();
      
        // return 'You are now logged out';
        return redirect('/')->with('success', "you are log out");

    }
    //function for profile
    private function getSharedData($usuario){
        //set value if you are not login to 0
        $currentlyFollowing = 0;
        if(auth()->check()){
           //lets check currently follow in order to delete, is true or false
            $currentlyFollowing = Follow::where([['user_id', '=', auth()->user()->id],['followeduser', '=', $usuario->id]])->count();
        }
        // this word posts() come from the user model, the function posts
        // return $usuario->posts()->get();
        //latest(0 come from the newest on top)
        //the last one in the array is to get the number of post by client
        //when i do with id
        //view has a static method so we can share, to access the blade template
        View::share('sharedData',['username' => $usuario->username,'id'=> $usuario->id,'postCount'=> $usuario->posts()->count(), 'avatar' =>$usuario->avatar, 'currentlyFollowing' => $currentlyFollowing,
        // followers() and followingTheseUsers() fuction come from user model
        'followerCount'=> $usuario->followers()->count(), 'followingCount'=>$usuario->followingTheseUsers()->count() ]);

    }

    //build the methaphore user and the 2 match the parameter router
    public function profile(User $usuario) {
        //coment this cuz will go to the shaaredData function
        // $currentlyFollowing = 0;
        // if(auth()->check()){           
        //     $currentlyFollowing = Follow::where([['user_id', '=', auth()->user()->id],['followeduser', '=', $usuario->id]])->count();
        // }   
        $this->getSharedData($usuario);     
        //comment this cuz it looks like that before goes in the shared data function
        // return view('profile-posts', ['username' => $usuario->username,'id'=> $usuario->id,'posts'=>$usuario->posts()->latest()->get(),'postCount'=> $usuario->posts()->count(), 'avatar' =>$usuario->avatar, 'currentlyFollowing' => $currentlyFollowing]);
        return view('profile-posts', ['posts'=>$usuario->posts()->latest()->get()]);
        //steps in case i want to work with username instead of id
        // return view('profile-posts', ['username' => $user->username,'posts'=>$user->posts()->latest()->get(),'postCount'=> $user->posts()->count(), 'avatar' =>$user->avatar]);
    }


    //Profile Followers
    public function profileFollowers(User $usuario) {
        $this->getSharedData($usuario); 
        //lets see the json
        // return $usuario->followers()->latest()->get(); 
        return view('profile-followers', ['followers'=>$usuario->followers()->latest()->get()]);                   
    }
    //Profile Following
    public function profileFollowing(User $usuario) {
        $this->getSharedData($usuario);  
        return view('profile-following', ['following'=>$usuario->followingTheseUsers()->latest()->get()]);      
    }

    //Change Avatar    
    public function showAvatarForm(){
        return view('avatar-form'); 
    }
    public function storeAvatar(Request $request){
        $request->validate([
            'avatar' => 'required|image|max:3000'
        ]);
    //we check inside the request for a method call file, the file we named avatar, call method store
    //it goes sotrage/app/public/avatars, the option below without package without resize
    // $request->file('avatar')->store('public/avatars');

    $user = auth()->user();
    //uniqid _>randomly generate set of character for a uniqued id
    $filename = $user->id .'_'. uniqid() . '.jpg';
           
    //after the package of intervention composer
    //dont forget to import the classes
        $imgData = Image::make($request->file('avatar'))->fit(120)->encode('jpg');
        Storage::put('public/avatars/'. $filename, $imgData);
        //delete old file database thats why we save
        $oldAvatar = $user->avatar;
        //now update the img database
        $user->avatar = $filename;
        $user->save();

        if($oldAvatar != "/fallback-avatar.jpg"){
            Storage::delete(str_replace("/storage/","public/",$oldAvatar));            
        }

        return back()->with('success', 'old image delete it');

    }

    //Profile SPA
    public function profileRaw(User $usuario) {        
        // we need to return json
        //globally view function, method of render to return a string
        return response()->json(['theHTML'=> view('profile-posts-only',['posts'=>$usuario->posts()->latest()->get()])->render(),'docTitle'=>$usuario->username ."'s Profile" ]);
    }

    
    //Profile Followers SPA
    public function profileFollowersRaw(User $usuario) {        
        return response()->json(['theHTML'=>view('profile-followers-only', ['followers'=>$usuario->followers()->latest()->get()])->render(),'docTitle'=>$usuario->username ."'s Followers" ]);
        
                           
    }
    //Profile Following SPA
    public function profileFollowingRaw(User $usuario) {
        return response()->json(['theHTML'=>view('profile-following-only', ['following'=>$usuario->followingTheseUsers()->latest()->get()])->render(),'docTitle'=>'Who ' . $usuario->username ." Follows" ]);      
    }


        
   
}
