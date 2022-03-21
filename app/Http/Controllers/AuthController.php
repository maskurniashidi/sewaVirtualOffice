<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
    }
}
