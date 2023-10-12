<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LikeController extends Controller
{
//
    public function like(Request $request, Post $post){
        $input = $request->validate([
            'post_id' => 'required',
            'user_id' => 'required'
        ]);


        $checking = DB::table('likes')
        ->select('likes.*')
        ->where('likes.user_id','=',$input['user_id'])
        ->where('likes.post_id','=',$input['post_id'])
        ->get();

        // $checking = $post->likedBy($request->input('user_id'));
        if($checking->count() == 0){
            Like::create($input);
        }

        return response()->json([
            'message' => 'Post Liked',
            'success' => 1,
        ]);
    }

    public function unlike(Request $request){
        $unliked = DB::table('likes')
        ->select('likes.*')
        ->where('user_id',$request->input('user_id'))
        ->where('post_id',$request->input('post_id'))
        ->get();

        $delete_like = Like::find($unliked[0]->id);

        if($delete_like->delete()){
            $res = [
                'message' => 'Post Unliked',
                'success' => 1,
            ];
            return response()->json($res);
        }
        $res = [
            'message' => 'Something went wrong !',
            'success' => 1,
        ];

        return response()->json($res);
    }
}
