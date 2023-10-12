<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    public function store(Request $request){
        $input = $request->validate([
            'post_id' => 'required',
            'user_id' => 'required',
            'content' => 'required',
        ]);


        Comment::create($input);
        $res = [
            'success' => 1,
            'message' => 'Comment Added !'
        ];

        return response()->json($res,200);
    }

    public function show($id){
        $comments = Post::find($id)->comments;

        return response()->json([
            'comments' => $comments
        ]);
    }
}
