<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
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

//blog controller
Route::get('/create-post', [PostController::class, "showCreateForm"])->middleware('MustBeLoggedIn');
Route::post('/create-post', [PostController::class, "storeNewPost"])->middleware('MustBeLoggedIn');
//the post in bracket need to match the name from the 2 paraments from the fuction on the controllers
Route::get('/post/{post}', [PostController::class, "viewSinglePost"]);
//only will delete, if the user is allow to delete
Route::delete('/post/{post}', [PostController::class, "delete"])->middleware('can:delete,post');
//this is for edit
Route::get('/post/{post}/edit', [PostController::class, "showEditForm"])->middleware('can:update,post');
Route::put('/post/{post}', [PostController::class, "actuallyUpdate"])->middleware('can:update,post');



//profile related routes, can be done with id instead of username, check also the layout.blade with id or username
Route::get('/profile/{usuario:id}', [UserController::class, "profile"]);
