@extends('layouts.app')

@section('title')
	<title>{{$post->title}}</title>
@endsection

@section('content')
	<h2>Edit post</h2>
	{!! Form::open(['action' => ['PostsController@update', $post->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!} <!-- This is Laravel Collective, a package to manipulate forms-->
    	<div class="form-group">
    		{{Form::label('title', 'Title')}}
    		{{Form::text('title', $post->title, ['class' => 'form-control', 'placeholder' => 'Title'])}}	
    	</div>
    	<div class="form-group">
    		{{Form::label('title', 'Content')}}
    		{{Form::textarea('content', $post->body, ['id' => 'article-ckeditor' ,'class' => 'form-control', 'placeholder' => 'Post content'])}}	
    	</div>
    	{{Form::hidden('_method', 'PUT')}} <!-- You have to insert this when you are updating a value from the database-->
        <div class="form-group">
            {{Form::file('cover_image')}}
        </div>
    	{{Form::submit('Save changes', ['class' => 'btn btn-primary'])}}
	    
@endsection
