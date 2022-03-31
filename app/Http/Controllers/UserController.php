<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getRentHistory($id)
    {
        $history = User::findOrFail($id)->rents;
        return $history;
    }
}
