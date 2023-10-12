<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    //

    public function index(){
        $posts = DB::table('posts')
        ->join('users','posts.user_id','=','users.id')
        ->select('posts.*','users.username')
        ->get();
        // $posts = Post::all();

        return response()->json($posts,200);
    }

    public function store(Request $request){
        $data = $request->all();

        $post = new Post();

        $post->user_id = $data['user_id'];
        $post->content = $data['content'];
        $post->save();

        $res = [
            'success' => true,
            'message' => 'Post created successfully !'
        ];

        return response()->json($res,200)->header('Content-Type','application/json');
    }

    

    public function bro(Post $post){
        return response()->json($post->check_post());
    }
}
