<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facility;
use App\Helpers\ResponseFormatter;
use Exception;


class FacilityController extends Controller
{

    public function index()
    {
    }

    public function store(Request $request)
    {
        try {
            $fields = $request->validate([
                'name' => 'required|string',
                'description' => 'nullable|string',
            ]);
        } catch (Exception $e) {
            return ResponseFormatter::error(
                null,
                'Invalid input',
            );
        }

        $facility = Facility::create([
            'name' => $fields['name'],
            'description' => $fields['description']
        ]);
        return ResponseFormatter::success(
            $facility,
            'New facility added'
        );
    }

    public function show($id)
    {
        try {
            $price = Facility::findOrFail($id);
        } catch (Exception $e) {
            report($e);
            return ResponseFormatter::error(
                report($e),
                'Facility not found'
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
                'name' => 'required|string',
                'description' => 'nullable|string',
            ]);
        } catch (Exception $e) {
            return ResponseFormatter::error(
                null,
                'Invalid input',
            );
        }
        try {
            $model = Facility::findOrFail($id);
        } catch (Exception $e) {
            return ResponseFormatter::error(
                null,
                'Facility id not found, can not update facility',
            );
        }
        $model->update($fields);
        return ResponseFormatter::success(
            $model,
            'Facility updated'
        );
    }

    public function destroy($id)
    {
        try {
            $facility = Facility::findOrFail($id);
        } catch (Exception $e) {
            report($e);
            return ResponseFormatter::error(
                report($e),
                'Facility id not found, can not delete facility'
            );
        }
        $facility->delete();
        return ResponseFormatter::success(
            null,
            'Facility deleted'
        );
    }
}
