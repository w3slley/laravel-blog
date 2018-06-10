@extends('layouts.app')

@section('title')
<title>Dashboard</title>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!--Welcome {{Auth::user()->name}}!  This is how you get the data of the users from the database! Auth::user()->name of the column from the db-->

                    <h3>Your blog posts</h3>
                    @if(count($posts)>0)

                        <table class="table table-striped"> 
                            <tr>    
                                <th style="text-align: center">Title</th>
                                <th></th>
                                <th></th>
                            </tr>
                        
                        @foreach($posts as $post)
                            <tr>
                                <td>{{$post->title}}</td>
                                <td><a class="btn btn-primary" href="/posts/{{$post->id}}/edit">Edit</a></td>
                                <td>
                                    {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => ' float-right'])!!}   
                                    {{Form::hidden('_method', 'DELETE')}}
                                    {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                    {!! Form::close() !!}
                                </td>
                            </tr>

                        @endforeach
                        </table>
                      
                      @else 
                      <p>You have no post!</p>

                      @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
