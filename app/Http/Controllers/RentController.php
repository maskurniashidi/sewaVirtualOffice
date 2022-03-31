<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use FFI\Exception;
use App\Models\Rent;
use App\Models\Service;

use App\Http\Controllers\ServiceController;

class RentController extends Controller
{

    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            "service_id" => 'required',
            "user_id" => 'required',
            "rentalStart" => 'required',
            "rentalEnd" => 'required',
            "duration" => 'required|numeric',
        ]);

        //$price = Service::findOrFail($fields["service_id"])->prices->where('duration' == $fields["duration"]);


        // // } catch (Exception $e) {
        // //     return ResponseFormatter::error(
        // //         null,
        // //         'required service_id and user_id'
        // //     );
        // // }

        //return $price;
        // $rent = Rent::create([
        //     'service_id' => $fields['service_id'],
        //     'user_id' => $fields['user_id'],
        //     'rentalStart' => $fields['rentalStart'],
        //     'rentalEnd' => $fields['rentalEnd'],
        //     'duration' => $fields['duration'],
        //     'totalPayment' => $price,
        // ]);
        // return $rent;
        // try {

        // } catch (Exception $e) {
        //     return ResponseFormatter::error(
        //         null,
        //         'failed to add new rent'
        //     );
        // }

        // //$rent->load('service');
        // return ResponseFormatter::success(
        //     $rent,
        //     'New rent has added'
        // );
    }

    public function show($id)
    {
        try {
            $model = Rent::findOrFail($id);
        } catch (Exception $e) {
            return ResponseFormatter::error(
                null,
                'Rent id not found'
            );
        }
        return ResponseFormatter::success(
            $model,
            'success'
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $fields = $request->validate([
                "service_id" => 'required',
                "user_id" => 'required',
            ]);
        } catch (Exception $e) {
            return ResponseFormatter::error(
                null,
                'required service_id and user_id'
            );
        }

        try {
            $model = Rent::findOrFail($id);
            $model->update($fields);
        } catch (Exception $e) {
            return ResponseFormatter::error(
                null,
                'failed to add new rent'
            );
        }
        return ResponseFormatter::success(
            $model,
            'New rent has updated'
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
}
