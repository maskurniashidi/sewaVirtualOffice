<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Unique;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => ['required', 'email:dns', 'unique:users'],
            'password' => 'required|min:8|max:255',
        ]);
        dd($validatedData);
        //User::create($validatedData);
        return $validatedData;
    }
}
