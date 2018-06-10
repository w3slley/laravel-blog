@extends('layouts.app')

@section('title')
	<title>{{$post->title}}</title>
@endsection
		
@section('content')
		<a href="/posts" class="btn btn-dark" style="margin-bottom: 10px">Go back</a>
		
		<div class="jumbotron ">
		@if($post->cover_image == '')

		@else
		<img class="img-fluid" style="margin-bottom: 20px" src="/storage/cover_images/{{$post->cover_image}}"> <!--This ensures that the blank image symbol will not be seen in the show page! -->
		@endif
		<h2>{{$post->title}}</h2>
		<p>{!!$post->body!!}</p> <!-- When using the ck-editor, you need to use the double exclamation mark between the post->body. Otherwise it will load html tags into the page -->	
		<hr>
		<small>Written on {{$post->created_at}} by {{$post->user['name']}}</small>	
		<hr>
		@guest <!-- This blade engine is fucking brilliant! Using the guest tag you can use logic to say if the user is not logged in (guest), (s)he will see this. If the user is logged in, (s)he will see that.-->

		@else
			@if(Auth::user()->id == $post->user['id']) <!-- If I do this, only the user who created the post will see the edit and delete buttons! -->
				<a href="/posts/{{$post->id}}/edit" class="btn btn-info">Edit</a>	
				{!!Form ::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => ' float-right'])!!}	
				{{Form::hidden('_method', 'DELETE')}}
				{{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
				{!! Form::close() !!}
			@else

			@endif
		@endguest
	</div>
@endsection
