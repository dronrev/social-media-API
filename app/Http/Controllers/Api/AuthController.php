<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {


        if (!$request->isMethod('post')) {
            $ipAddress = $request->ip();
            return response()->json([
                'message' => 'Wrong Request Method!',
                'IP' => $ipAddress
            ], 200)->header('Content-Type', 'application/json');
        }


        $input = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($input)) {
            $token = $request->user()->createToken('login_token');
            $res = [
                'success' => 1,
                'message' => 'Success',
                'token' => $token->plainTextToken
            ];
            return response()->json($res, 200)->header('Content-Type', 'application/json');
        }
        $res = [
            'success' => 0,
            'message' => 'Wrong Email or Password',
        ];
        return response()->json($res, 200)->header('Content-Type', 'application/json');
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        $user->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json([
            'message' => 'Logged Out!'
        ]);
    }
}
