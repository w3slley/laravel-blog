<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post; //To display the posts inside the post page.
//use DB; //Write this to use sql statements!
use Illuminate\Support\Facades\Storage; //This imports the storage library, which allows me, in this case, to delete files from the system. The funny thing is that almost none of the functions used here are built in functions from php. Almost all of them consist of library functions...

class PostsController extends Controller
{
 

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]); //With this, the user will only see the create page if (s)he is logged in. The thing is, if it's just that, it will not allow the user to see the blog posts at all. You have to add that except and tell what pages should allow the user to go in without login!
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //This uses Eloquent!
        //$posts = Post::all(); //This will get the data from the database!
        //$posts = Post::where('title', 'Post one')->get();//You can use Where here too. The Post over there is the model!!
        //$posts = DB::select('SELECT * FROM posts');//You can use sql queries as well - you have to use DB up there!

        //$posts = Post::orderBy('id', 'desc')->get();//This will order the posts by id, or whatever column I insert in the first parameter. The second parameter is the order: desc/asc.
        $posts = Post::orderBy('id', 'desc')->paginate(7) ;//This is fucking awesome. You can paginate the posts so easily using laravel! This is good to know
        //$posts = Post::where('user_id', auth()->user()->id)->get(); //This will get all the posts created by the user with the user_id. Don't forget the ->get()!

        return view("posts.index")->with('posts', $posts);//This is how you display the posts inside the webpage. The variable $posts goes to the view and we can display there!

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()//Goes to a view page to insert the data. Later on it goes to the method store.
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)//This method deals with inserting data inside the DB!
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required', //This prevents the user to add empty data into the database and makes the user to write something both in the title and in the content form.
            'cover_image' => 'image|nullable|max:1999' //This will allow the input to be a image and a maximum size of 1.9mb
        ]);

        //Handle file upload
        if($request->hasFile('cover_image')){//If the user actually upload a file:
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName(); //This will get the name of the file!
            //$file = explode('.', $fileNameWithExt);//You could also use this!
            //$fileName = $file[0]; //This is the file name
            //$fileExt = $file[1]; //This is the extension!
            //Get file name
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            //Get file extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();//This gets the file extension. Again, you coult use the explode function!
            $fileNameToStore = $filename."_".time().".".$extension; //creates a new filename with its name + the time it was added!
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);//This uploads the image inside the public/cover_images folder!


        }
        else {
            $fileNameToStore = '';//If the user don't, in the database the cover_image row will be blank!
        }
        
        //Create Post (the same thing I did inside the GIT bash with tinker)
        $post = new Post; //Post is the name of the model I created!
        $post->title = $request->input('title'); //The data submited in the create page. You access it by using the variable $request and using the method input with the name of the tag you inserted in the first parameter of the Post::text in the create.blade.php file
        $post->body = $request->input('content');
        $post->user_id = auth()->user()->id;//This is how you access the table users!! I was searching and searching for something like this. Now I found it!
        $post->cover_image = $fileNameToStore;
        $post->save();
        //You only have to do this to add the data inside the database. With lavarel, is that easy!!
        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)//Displays the data based on the id of the post. Then it leads the user into the show.blade.php file with the $post variable been the data from the database I got from the model.
    {
        //return Post::find($id);//This finds the post inside the database using the id that it's in the url!
        $post = Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)//This finds the post by the id used as input. Then, it displays the post from the posts.blade.php file in the views folder.
    {
        $post = Post::find($id);
        if(auth()->user()->id == $post->user_id){//If the id of the user logged in is different from the user_id from the posts table, than it wont show the create post file!
            return view('posts.edit')->with('post', $post);
        }
        else {
            return redirect('/posts')->with('error', 'Unauthorized Page'); //This will throw an error if the id of the user is different from the user_id from the posts table.
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)//This gets the data sended in the edit view page and turns into the variable $request, which I can now add to the database.
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required', //This prevents the user to add empty data into the database and makes the user to write something both in the title and in the content form.
            'cover_image' => 'image|nullable|max:1999'
        ]);

        //Handle file upload
        if($request->hasFile('cover_image')){//If the user actually upload a file:
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName(); //This will get the name of the file!
            //$file = explode('.', $fileNameWithExt);//You could also use this!
            //$fileName = $file[0]; //This is the file name
            //$fileExt = $file[1]; //This is the extension!
            //Get file name
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            //Get file extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();//This gets the file extension. Again, you coult use the explode function!
            $fileNameToStore = $filename."_".time().".".$extension; //creates a new filename with its name + the time it was added!
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);//This uploads the image inside the public/cover_images folder!


        }
        
        
        //Create Post (the same thing I did inside the GIT bash with tinker)
        $post = Post::find($id); //Here insted of creating a new Post, you will insert the find method to get the id.
        $post->title = $request->input('title'); //Here is the same thing as the store.
        $post->body = $request->input('content');//Same thing as well
        if($request->hasFile('cover_image')){ //If the user adds a new image in the edit section, then it will add to the database and to the /storage/cover_images folder! If not, nothing happens and the older image stays in the post.
            $post->cover_image = $fileNameToStore;   
        }
        $post->save();
       
        return redirect('/posts')->with('success', 'Post Updated');//Here you change the message to post update.

        //This is how you update values from the database with Laravel!
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $post = Post::find($id);

       if($post->cover_image != ''){
        Storage::delete('public/cover_images/'.$post->cover_image);//This is how you delete a file using the Storage library! It's an library of the laravel framework..
       }

       if($post->user_id == auth()->user()->id){
            $post->delete();
            return redirect('/posts')->with('success', 'Post Deleted');

       }

       
        redirect('/posts')->with('error', 'Unauthorized Page');
       
       
    }
}
