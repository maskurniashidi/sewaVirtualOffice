<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\ResponseFormatter;
use Exception;

class UserController extends Controller
{
    public function getRentHistory($id)
    {
        try {
            $history = User::findOrFail($id)->rents;
        } catch (Exception $e) {
            return ResponseFormatter::error(null, 'User have not any data');
        }
        return $history;
    }
}
