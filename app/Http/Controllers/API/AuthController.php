<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nickname' => 'required|min:3|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ]);
        }

        $obj = new User;
        $obj->nickname = $request->input('nickname');
        $obj->email = $request->input('email');
        $obj->password = bcrypt($request->input('password'));
        $obj->slug = strstr($request->input('email'), '@', true);
        // $obj->bg_pic = 'assets/img/default-profile-banner.jpg';
        // $obj->profile_pic = 'assets/img/default-ava.png';
        $obj->save();

        return response()->json([
            'status' => 'ok'
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()
            ]);
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($credentials)) {
            /** @var \App\Models\User $user **/
            $user = auth()->user();

            return response()->json([
                'status' => 'ok',
                'token' => $user->createToken('myAppToken')->plainTextToken,
                'user' => $user
            ]);
        }

        return response()->json([
            'status' => 'failed',
            'message' => 'Email atau password salah.'
        ]);
    }

    public function logout(Request $request)
    {
        if ($request->user()->currentAccessToken()->delete()) {
            return response()->json([
                'status' => 'ok'
            ]);
        }

        return response()->json([
            'status' => 'failed',
            'message' => 'Gagal logout'
        ]);
    }
}