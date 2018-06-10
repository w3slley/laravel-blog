<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
Route::get('/users/{id}/{name}', function($id, $name){ //This is how you can pass data with laravel! The variable goes inside {} and as a variable inside the function parameters. Then, they can be manipulated inside the function.
	return "This is user ".$name." who has an ID of ".$id;
});

Route::get('/about', function(){
	return view('pages/about');
});

*/

Route::get('/', 'PagesController@index');//This tells laravel to go to the PagesController I created using artisan. It's in the folder app/Http/PagesController.php. It returns the view of the folder pages and the index file from that folder. These files are inside the folder views!
Route::get('/about', 'PagesController@about');

Route::get('/services', 'PagesController@services');

Route::resource('posts', 'PostsController'); //This will create all the routes we need for the functions created at PostsController.php




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
