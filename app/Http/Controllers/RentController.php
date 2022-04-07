<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Models\Rent;
use App\Models\Service;
use App\Models\User;
use App\Http\Controllers\ServiceController;
use Exception;
use Auth;
use Response;

class RentController extends Controller
{

    public function index()
    {
        $rents = Rent::all();
        $rents->load('service');
        $rents->load('user');
        return $rents;
    }

    public function storeMany(Request $request)
    {
        $myRent = [];
        $total = 0;
        foreach ($request->rents as $data) {
            $rent = new Rent();
            $rent->service_id = $data['service_id'];
            $rent->user_id = $data['user_id'];
            $rent->rentalStart = $data['rentalStart'];
            $rent->rentalEnd = $data['rentalEnd'];
            $rent->duration = $data['duration'];

            try {
                $prices = Service::findOrFail($rent->service_id)->prices->where('duration', $rent->duration);
                $price = $prices[0]->price;
            } catch (Exception $e) {
                $prices = Service::findOrFail($rent->service_id)->prices->where('duration', 1);
                $price = $prices[0]->price * $rent->duration;
            }
            $rent->totalPayment = $price;
            $rent->save();
            $total += $price;
            $rent->service;
            $myRent = array(...$myRent, $rent);
        }
        return Response::json(array(
            'message' => "Data Successfully Added",
            'rents' => $myRent,
            'total' => $total,
        ), 200);
    }
    public function store(Request $request)
    {
        try {
            $fields = $request->validate([
                "service_id" => 'required',
                "user_id" => 'required',
                "rentalStart" => 'required',
                "rentalEnd" => 'required',
                "duration" => 'required|numeric',
            ]);
        } catch (Exception $e) {
            return ResponseFormatter::error(
                null,
                'Invalid input'
            );
        }
        try {
            $prices = Service::findOrFail($fields["service_id"])->prices->where('duration', $fields["duration"]);
            $price = $prices[0]->price;
        } catch (Exception $e) {
            $prices = Service::findOrFail($fields["service_id"])->prices->where('duration', 1);
            $price = $prices[0]->price * $fields['duration'];
        }
        try {
            $rent = Rent::create([
                'service_id' => $fields['service_id'],
                'user_id' => $fields['user_id'],
                'rentalStart' => $fields['rentalStart'],
                'rentalEnd' => $fields['rentalEnd'],
                'duration' => $fields['duration'],
                'totalPayment' => $price,
            ]);
        } catch (Exception $e) {
            return ResponseFormatter::error(
                null,
                'failed to add new rent'
            );
        }
        $rent->load('user');
        $rent->load('service');
        return ResponseFormatter::success(
            $rent,
            'New rent has added'
        );
    }

    public function show($id)
    {
        try {
            $rent = Rent::findOrFail($id);
        } catch (Exception $e) {
            return ResponseFormatter::error(
                null,
                'Rent id not found'
            );
        }
        $rent->load('user');
        $rent->load('service');
        return ResponseFormatter::success(
            $rent,
            'success'
        );
    }

    public function destroy($id)
    {
        try {
            $model = Rent::findOrFail($id);
            $model->delete();
        } catch (Exception $e) {
            return ResponseFormatter::error(
                null,
                'failed to delete rent data'
            );
        }
        return ResponseFormatter::success(
            null,
            'The rent data was deleted'
        );
    }
    public function getRentHistory($id)
    {
        $user = User::findOrFail($id);
        try {
            $rents = Rent::all()->where('user_id', $id);
            $rents->load('service');
        } catch (Exception $e) {
            return ResponseFormatter::error(null, 'User have not any data');
        }
        return ['user' => $user, 'rents' => $rents];
    }
}
