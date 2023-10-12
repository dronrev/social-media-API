<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    public function index(){
        $users = User::all();

        return response()->json($users,200);
    }

    public function store(Request $request){
        $validation = $request->validate([
            'username' => 'required',
            'email' => 'required',
            'name' => 'required',
            'password' => 'required'
        ]);

        $new_user = new User();
        $new_user->username = $request->input('username');
        $new_user->email = $request->input('email');
        $new_user->name = $request->input('name');
        $new_user->password = $request->input('password');

        $new_user->save();

        $res = [
            'success' => true,
            'message' => 'User create successfully !'
        ];

        return response()->json($res,200);
    }

    public function show($id){
        $user = User::find($id);

        return response()->json($user,200);
    }

    public function update(Request $request,$id){
        $input = $request->all();
        $user = User::find($id);

        $user->username = $input['username'];
        $user->name = $input['name'];
        $user->email = $input['email'];
        // $user->password = $input['password'];
        $user->bio = $input['bio'];
        $user->profile_image = $input['profile_image'];

        $user->save();

        $res = [
            'success' => true,
            'message' => 'Updated !'
        ];
        return response()->json($res,200);
    }
}
