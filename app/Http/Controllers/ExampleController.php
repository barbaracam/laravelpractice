<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    // public function homepage(){
    //     $ourName = 'Barbie';
    //     $animals = ['dog', 'cat', "rabbit"];
    //     //we transfer this information to the view and become $name the info from $ourName
    //    return view('homepage', ['allAnimals'=>$animals,'name'=> $ourName, 'catName'=>'cutiecat']);
    // }
    public function aboutPage2(){
        return '<h1>About with controller </h1><a href="/">Back to main</a>'; 
    }

    public function homepage(){
        $ourName = 'Barbie';
        $animals = ['dog', 'cat', "rabbit"];
        //we transfer this information to the view and become $name the info from $ourName
       return view('homepage', ['allAnimals'=>$animals,'name'=> $ourName, 'catName'=>'cutiecat']);
    }
    public function aboutPage(){
        return view('single-post'); 
    }
}
