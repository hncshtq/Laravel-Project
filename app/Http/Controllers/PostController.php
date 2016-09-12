<?php
namespace App\Http\Controllers;

use App\Post;
use App\Like;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function getDashboard() //return the view of dashboard
    {
        $posts = Post::orderBy('created_at', 'desc')->get(); //fetch the posts by descending order, make the latest post at the top
        return view('dashboard', ['posts' => $posts]);
    }
    
    public function postCreatePost(Request $request)
    {
        $this->validate($request,[
            'body' => 'required|max:1000'                     
        ]);
        
        $post = new Post();
        $post->body = $request['body'];
        $message = 'Sorry, the post fail, there are some error, please post again.';
        if($request->user()->posts()->save($post))
        {
            $message = 'Post successfully created!';
        }
        return redirect()->route('dashboard')->with(['message' => $message]); //with function allow attach some message
        
    }
    
    //The delete function to delete post
    public function getDeletePost($post_id)
    {
        $post = Post::where('id', $post_id)->first(); //delete the post by post's id
        if (Auth::user() != $post -> user){
            return redirect() -> back();
        }
        $post->delete();
        return redirect()->route('dashboard')->with(['message' => 'Successfully deleted!']);
    }
    
    //The edit function to edit post
    public function postEditPost(Request $request)
    {
        $this -> validate($request, [
            'body' => 'required'
        ]);
        
        $post = Post::find($request['postId']);
        if (Auth::user() != $post -> user){
            return redirect() -> back();
        }
        $post->body = $request['body'];
        $post->update();
        return response() -> json(['new_body' => $post->body], 200);
    }
    
    public function postLikePost(Request $request) //Ajax request handle
    {
        $post_id = $request['postId'];
        $is_like = $request['isLike'] === 'true';
        $update = false;
        $post = Post::find($post_id);
        if (!$post){
            return null;
        }
        $user = Auth::user();
        $like = $user->likes()->where('post_id',$post_id)->first();
        if ($like){
            $already_like = $like->like;
            $update = true;
            if($already_like == $is_like){
                $like->delete();
                return null;
            }
        }
        else{
            $like = new Like();
        }
        $like->like = $is_like;
        $like->user_id = $user->id;
        $like->post_id = $post->id;
        if ($update){
            $like -> update();
        }
        else{
            $like -> save();
        }
        return null;
    }
    
}