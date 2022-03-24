<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Helpers\ResponseFormatter;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        //return  $request->password;
        $validate = $request->validate([
            "name" => 'required|max:255',
            "email" => 'required|email:dns|unique:users',
            'password' => 'required|min:8|max:255'
        ]);
        //enkripsi password
        $validate["password"] = bcrypt($validate["password"]);
        User::create($validate);
        return ResponseFormatter::success(
            $validate,
            'New service created.'
        );
    }
    public function login(Request $request)
    {
        $validate = $request->validate([
            "email" => 'required|email:dns',
            'password' => 'required|min:8|max:255'
        ]);
        //return $validate;
        if (Auth::attempt($validate)) {
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('access_token')->plainTextToken;
            return ResponseFormatter::success([
                'token' => $token,
                'user' => $user
            ], 'Login Success');
        } else {
            return ResponseFormatter::error(null, 'Login failed');
        }
    }
    public function logout(Request $request)
    {

        $request->user()->tokens()->delete();
        if (Auth::user()->current) {
            return ResponseFormatter::error(null, 'Something went wrong', 404);
        }
        Auth::logout();
        return ResponseFormatter::success(null, 'Logout successful');
    }
}
