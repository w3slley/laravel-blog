@extends('layouts.app')

@section('title')
	<title>Add post</title>
@endsection

@section('content')
    @include('inc.message')
	<h2>Create post</h2>
	{!! Form::open(['action' => 'PostsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!} <!-- This is Laravel Collective, a package to manipulate forms-->
    	<div class="form-group">
    		{{Form::label('title', 'Title')}}
    		{{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}	
    	</div>
    	<div class="form-group">
    		{{Form::label('title', 'Content')}}
    		{{Form::textarea('content', '', ['id' => 'article-ckeditor' ,'class' => 'form-control', 'placeholder' => 'Post content'])}}	
    	</div>
        <div class="form-group">
            {{Form::file('cover_image')}}
        </div>
    	{{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
	    
@endsection

