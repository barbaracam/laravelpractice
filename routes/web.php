<?php

use App\Events\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;
// use App\Http\Controllers\ExampleController; practicing controller


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/about', [ExampleController::class, "aboutPage"]); we comment as was practicing
//dont forget to import class to see the name space on the top created
// info in the line routers page, controller, name of the function controller

//user controller
Route::get('/', [UserController::class, "showCorrectHomepage"])->name('login');
Route::post('/register', [UserController::class, "register"])->middleware('guest');
Route::post('/login', [UserController::class, "login"])->middleware('guest');
Route::post('/logout', [UserController::class, "logout"])->middleware('MustBeLoggedIn');
Route::get('/manage-avatar', [UserController::class, "showAvatarForm"])->middleware('MustBeLoggedIn');
Route::post('/manage-avatar', [UserController::class, "storeAvatar"])->middleware('MustBeLoggedIn');


//BLOG CONTROLLER
//1.a - the word post in bracket need to match the name from the 2 paraments from the fuction on the controllers
//1.b only will delete, if the user is allow to delete (can:delete, post..)
//remember to change the file under the policies folder and the AuthServicesProvider as well
Route::get('/create-post', [PostController::class, "showCreateForm"])->middleware('MustBeLoggedIn');
Route::post('/create-post', [PostController::class, "storeNewPost"])->middleware('MustBeLoggedIn');
Route::get('/post/{post}', [PostController::class, "viewSinglePost"]);
Route::delete('/post/{post}', [PostController::class, "delete"])->middleware('can:delete,post');
//this is for edit
Route::get('/post/{post}/edit', [PostController::class, "showEditForm"])->middleware('can:update,post');
Route::put('/post/{post}', [PostController::class, "actuallyUpdate"])->middleware('can:update,post');
Route::get('/search/{surprise}', [PostController::class, "search"]);


//profile related routes, 
//can be done with id instead of username, check also the layout.blade with id or username
Route::get('/profile/{usuario:id}', [UserController::class, "profile"]);
Route::get('/profile/{usuario:id}/followers', [UserController::class, "profileFollowers"]);
Route::get('/profile/{usuario:id}/following', [UserController:: class, "profileFollowing"]);

//profile related routes with js spa, 
//can be done with id instead of username, check also the layout.blade with id or username
Route::get('/profile/{usuario:id}/raw', [UserController::class, "profileRaw"]);
Route::get('/profile/{usuario:id}/followers/raw', [UserController::class, "profileFollowersRaw"]);
Route::get('/profile/{usuario:id}/following/raw', [UserController:: class, "profileFollowingRaw"]);

// Route::get('/profile/{user:username}', [UserController::class, "profile"]);

//follow relates routes
Route::post('/create-follow/{user:id}',[FollowController::class, 'createFollow'])->middleware('MustBeLoggedIn');
Route::post('/remove-follow/{user:id}',[FollowController::class, 'removeFollow'])->middleware('MustBeLoggedIn');


//gates
// (very similar to policy but a policy includes CRUD, gate simplier activities)

//option1
// Route::get('/admin-only', function() {
//     if(Gate::allows('visitAdminPages')){
//         return "Only admin are allow";
//     }
//     return "You cannot see this page";
// });

//option 2 gate with middleware
Route::get('/admin-only', function() {
    return "You are an Admin";
})->middleware('can:visitAdminPages');

//chat route
Route::post('/send-chat-message', function(Request $request){
$formFields = $request->validate([
    'textvalue' => 'required'
]);
if(!trim(strip_tags($formFields['textvalue']))){
    return response()->noContent(); 
}

//we are broadcasting a new instance of a chat message event to others
 broadcast(new ChatMessage(['username'=>auth()->user()->username, 'textvalue'=> strip_tags($request->textvalue), 'avatar'=> auth()->user()->avatar]))->toOthers();
return response()->noContent();

})->middleware('MustBeLoggedIn');
