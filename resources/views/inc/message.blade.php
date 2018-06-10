<!-- This file will display messages in the create post page. -->

@if(count($errors)>0) <!-- If there's any error: -->
	@foreach($errors->all() as $error)
		<div class="alert alert-danger"> <!-- It will display all of them -->
			{{$error}}
		</div>
	@endforeach
@endif

@if(session('success')) <!-- If the session was open with no errors: -->
	<div class="alert alert-success"><!-- This session value is passed when the data is added into the database. It's passed in the redirect part.-->
		{{session('success')}}
	</div>
@endif

@if(session('error'))
	<div class="alert alert-danger">
		{{session('error')}}
	</div>
@endif