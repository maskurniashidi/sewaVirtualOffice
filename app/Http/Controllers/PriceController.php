<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Price;
use App\Helpers\ResponseFormatter;
use App\Exceptions;
use Throwable;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'price' => 'required|numeric',
            'duration' => 'required|integer',
            'unit' => 'required|string',
            "service_id" => 'required',
        ]);

        if (!$fields) {
            return ResponseFormatter::error(
                null,
                'Invalid input',
                400
            );
        }

        $growth = Price::create([
            'price' => $fields['price'],
            'duration' => $fields['duration'],
            'unit' => $fields['unit'],
            'service_id' => $fields['service_id']
        ]);

        return ResponseFormatter::success(
            $growth,
            'New price added'
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $price = Price::findOrFail($id);
            if ($price) {
                return ResponseFormatter::success(
                    $price,
                    'success'
                );
            }
        } catch (Throwable $e) {
            report($e);
            return ResponseFormatter::error(
                report($e),
                'Price not found'
            );
        }
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
        $fields = $request->validate([
            'price' => 'required|numeric',
            'duration' => 'required|integer',
            'unit' => 'required|string',
            "service_id" => 'required',
        ]);

        $model = Price::find($id);
        // return $model;
        $model->update($fields);

        if ($model) {
            return ResponseFormatter::success(
                $model,
                'Price updated'
            );
        } else {
            return ResponseFormatter::error(null, "Price failed to update", 400);
        }
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
            $price = Price::findOrFail($id);
            $price->delete();
            if ($price) {
                return ResponseFormatter::success(
                    null,
                    'Price deleted'
                );
            }
        } catch (Throwable $e) {
            report($e);
            return ResponseFormatter::error(
                report($e),
                'Price not found, cannot delete'
            );
        }
    }
}
