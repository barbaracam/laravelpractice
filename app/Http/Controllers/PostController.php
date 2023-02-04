<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //get request to get the post website
    public function showCreateForm(){
        // if(!auth()->check()) {
        //     return redirect('/');
        // } if i dont want to use middleware
        return view('create-post');
    }

    //post request 
    public function storeNewPost(Request $request) {
        $incomingFields = $request->validate([
            'title'=>'required',
            'body'=>'required'
        ]);

        //this the info that goes inside the table
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();

        //dont forget importing the class
        $newPost = Post::create($incomingFields); 

        //we need to create a model because the system wont understand and send all the information from every field as a string without being separated
        
        // we will redirect to the post that was created so we need to access the $newpPost than we keep in a variable        
        return redirect("/post/{$newPost->id}")->with('success', 'New post succefully created');
        
    }
    // parament Post is from the post model and $post match the controller {post}
    public function viewSinglePost(Post $post){
        //sample without policy
        // if($post->user_id === auth()->user()->id){
        // return 'you are the author';
        //} else {
        // return "you are not";
        //}
        //laravel have a class call Str::markdown and we need it to import too right click
        $ourHTML = strip_tags(Str::markdown($post->body), '<p><ul><li><strong><em><br>');
        $post['body'] = $ourHTML;
        // return $post->title;
        //we need pass the $post data in the blade view and [ one property]
        return view('single-post',['post' => $post]);            
        }

    public function delete(Post $post){
        if (auth()->user()->cannot('delete',$post )){
            return "you cant";
        }
        $post->delete();
        //in the example is user()->username...
        return redirect('/profile/' . auth()->user()->id)->with('success',"Post delete it yay!" );
    }
    //get back to the blade from single post and change delete lines
    //create a view blade for edit-post
    public function showEditForm(Post $post){
        return view('edit-post',['post' => $post]); 
    }
    public function actuallyUpdate(Post $post, Request $request){
        $incomingFields = $request->validate([
            'title'=>'required',
            'body'=>'required'
        ]);
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        // the relationship already exist, the instance is power by a model we only access the previus information, we only need to call a method update()
        $post->update($incomingFields);      
        // back is to return last page
        return back()->with('success', 'Post was updated yaya');
    }

}
