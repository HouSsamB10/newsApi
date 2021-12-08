<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentsResource;
use App\Http\Resources\PostCommentsResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostsResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
class PostController extends Controller
{
  
    public function index()
    {
        return new PostsResource(Post::with('comments' , 'user' , 'category')->paginate());
    }

  
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'category_id' => 'required',
            'featured_image' =>  'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = $request->user();

        $post = new Post();

        $post->title = $request->get('title');
        $post->content = $request->get('content');

        if(intval($request->get('category_id')) != 0){
            $post->category_id = intval($request->get('category_id'));

        }
        $post->user_id = $user->id;
     
     
        // todo handle featured_image file upload
        if($request->hasFile('featured_image')) {
            $user_img_name = $request->file('featured_image');
            $user_name = time().'.'.$user_img_name->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $user_img_name->move($destinationPath, $user_name);
    
            $post->featured_image = $destinationPath.'/'.$user_name;
    
          }


       
        $post->votes_up = 0 ; 

        $post->votes_down = 0 ; 

        $post->date_written = Carbon::now()->format('Y-m-d H:i:s');


        $post->save();

        return new PostResource( $post);
    }

 
    public function show($id)
    {   
         $post=  Post::with(['comments', 'user','category'])->where('id' , $id )->get();

       return new PostResource( $post);
    }

  
    public function update(Request $request, $id)
    {
    

        $user = $request->user();

        $post = Post::find($id);
 

        if(  $request->has('title') ){
            $post->title = $request->get('title');
        }
        if(  $request->has('content') ){
            $post->content = $request->get('content');
        }
        if( $request->has('category_id') ){

        if(intval($request->get('category_id')) != 0){
            $post->category_id = intval($request->get('category_id'));

        }
        }

       
     
     
        // todo handle featured_image file upload 
        if($request->hasFile('featured_image')) {
            $user_img_name = $request->file('featured_image');
            $user_name = time().'.'.$user_img_name->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $user_img_name->move($destinationPath, $user_name);
    
            $post->featured_image = $destinationPath.'/'.$user_name;
    
          }
     

        $post->save();

        return new PostResource( $post);
    }

 
    public function destroy($id)
    {
        $post =Post::find($id);
        $post->delete();
       return new PostResource($post);
        
    }

    
 /**
  * Undocumented function
  *
  * @param [type] $id
  * @return void
  */
    public function comments($id)
    {
       $post = Post::find($id);
       $comments = $post->comments()->paginate();

       return new CommentsResource($comments);

    }
}
