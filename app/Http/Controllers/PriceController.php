<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Price;
use App\Helpers\ResponseFormatter;
use App\Models\Service;
use Exception;
use Throwable;

class PriceController extends Controller
{

    public function store(Request $request)
    {
        try {
            $fields = $request->validate([
                'price' => 'required|numeric',
                'duration' => 'required|integer',
                'unit' => 'required|string',
                "service_id" => 'required',
            ]);
        } catch (Exception $e) {
            return ResponseFormatter::error(
                null,
                'Invalid input'
            );
        }

        try {
            Service::findOrFail($fields["service_id"]);
        } catch (Exception $e) {
            return ResponseFormatter::error(
                null,
                'Service id not found, can not add the price'
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

    public function show($id)
    {
        try {
            $price = Price::findOrFail($id);
        } catch (Throwable $e) {
            report($e);
            return ResponseFormatter::error(
                report($e),
                'Price not found'
            );
        }
        return ResponseFormatter::success(
            $price,
            'success'
        );
    }
    public function update(Request $request, $id)
    {
        try {
            $fields = $request->validate([
                'price' => 'required|numeric',
                'duration' => 'required|integer',
                'unit' => 'required|string',
                "service_id" => 'required',
            ]);
        } catch (Exception $e) {
            return ResponseFormatter::error(
                null,
                'Invalid input'
            );
        }
        try {
            $model = Price::findOrFail($id);
        } catch (Exception $e) {
            return ResponseFormatter::error(null, "Price id not found, failed to update");
        }
        try {
            Service::findOrFail($fields["service_id"]);
        } catch (Exception $e) {
            return ResponseFormatter::error(
                null,
                'Service id not found, can not add the price'
            );
        }

        $model->update($fields);
        return ResponseFormatter::success(
            $model,
            'Price updated'
        );
    }

    public function destroy($id)
    {
        try {
            $price = Price::findOrFail($id);
            $price->delete();
        } catch (Throwable $e) {
            report($e);
            return ResponseFormatter::error(
                report($e),
                'Price not found, cannot delete'
            );
        }
        return ResponseFormatter::success(
            null,
            'Price deleted'
        );
    }
}
