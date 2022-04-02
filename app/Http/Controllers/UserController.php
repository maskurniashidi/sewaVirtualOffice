<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Exception;
use App\Models\User;

class UserController extends Controller
{
    // public function getRentHistory($id)
    // {
    //     try {
    //         $rents = Rent::all()->where('user_id',$id);
    //     } catch (Exception $e) {
    //         return ResponseFormatter::error(null, 'User have not any data');
    //     }
    //     return $history;
    // }
}
