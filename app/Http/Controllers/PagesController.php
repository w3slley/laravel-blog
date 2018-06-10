<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller{
    public function index (){
    	$title = 'Welcome to Laravel!!!';
    	//return view("pages.index", compact('title'));//To pass values to the layout page, use compact()! Then, you can insert inside the tag you want the variable inside {{}}! Ex:    <h1>{{$title}}</h1>. It has to be the same name as the variable!
    	return view("pages.index")->with('title', $title);//This is another way to do it.
    }

    public function about () {//displays the about.blade.php file inside the views/page folder! The route than displays this!
    	$title = 'This is the about page.';
    	return view("pages.about")->with('title', $title);
    }

    public function services() {//displays the services.blade.php file inside the views/page folder! The route than displays this!
    	$data = array(
    		'title' => 'These are the services we provide:',
    		'services' => ['Cyber security advisory', 'Software engineering', 'Data analysis']
    	);//These arrays are passed to the view files and can be used there! With blade, you can use logic (if, while, foreach, etc).
    	return view("pages.services")->with($data);
    }
}
