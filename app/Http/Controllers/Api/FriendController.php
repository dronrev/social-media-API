<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Friend;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    //
    public function add_friend(Request $request){
        $input = $request->validate([
            'user_id' => 'required',
            'friend_id' => 'required',
        ]);

        // to check if friend request is exist
        $is_exists = Friend::where('user_id',$input['user_id'] )
        ->where('friend_id',$input['friend_id'] )
        ->first();

        if($is_exists->count() > 0){
            $res = [
                'message' => 'Request already sent !',
                'success' => 1
            ];
            return response()->json($res,200);
        }

        // send friend request
        $friend_connection = new Friend();
        $friend_connection->user_id = $input['user_id'];
        $friend_connection->friend_id = $input['friend_id'];
        $friend_connection->status = 'pending';
        if($friend_connection->save()){
            $res = [
                'success' => 1,
                'message' => 'Friend Request sent!'
            ];

            return response()->json($res,200);
        }
        
        $res = [
            'success' =>0,
            'message' => 'Something went wrong ! '
        ];

        return response()->json($res,401);
    }

    public function accept_friend(Request $request){
        $input = $request->all();
        $accepted = Friend::find($input['id']);

        $accepted->status = 'accepted';

        if($accepted->save()){
            $res = [
                'success' => 1,
                'message' => 'Friend Request Accepted !'
            ];

            return response()->json($res,200);
        }
        $res = [
            'success' =>0,
            'message' => 'Something went wrong ! '
        ];

        return response()->json($res,401);
    }
}
