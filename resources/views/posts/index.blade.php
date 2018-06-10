@extends('layouts.app')

@section('title')
	<title>Posts</title>
@endsection


@section('content')
	@include('inc.message')
	<h2 class="text-center">Posts</h2>

	@if(count($posts)>0)
		@foreach($posts as $post)
			<div style="margin-bottom: 20px" class="card">
				<div class="row">
					<div class="col-lg-3" style="padding:10px 10px 10px 30px">
						@if($post->cover_image == '')

						@else
						<img style="width:100%; border-radius: 5px" src="/storage/cover_images/{{$post->cover_image}}" width="200px" height="200px"><!--This ensures that the blank image symbol will not be seen in the index page! -->
						@endif 
					</div>
					<div class="col-lg-9" style="padding:20px">
						<h2><a href="/posts/{{$post->id}}">{{$post->title}}</a></h2>

						<p>Written on {{$post->created_at}} by {{$post->user['name']}}</p> <!-- the $post->user['name'] only worked because we inserted that line of code in the models page (User and Post)!-->
				
					</div>
				</div>
				
			</div>
		@endforeach
		 {{$posts->links()}}<!-- This displays the pagination! -->
	@else 
		<p>No posts</p>
	@endif 
@endsection
