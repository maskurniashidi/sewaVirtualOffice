<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Response;
use App\Helpers\ResponseFormatter;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseFormatSame;
use Exception;

class ServiceController extends Controller
{

    public function index()
    {
        $services = Service::all();
        $services->load('images');
        $services->load('prices');
        $services->load('facilities');
        return ResponseFormatter::success(
            $services,
            'Get services success'
        );
    }

    public function store(Request $request)
    {
        try {
            $fields = $request->validate([
                'name' => 'string|required|max:255',
                'space' => 'numeric|required',
                'capacity' => 'integer|required',
                'description' => 'nullable|string',
            ]);
        } catch (Exception $e) {
            return ResponseFormatter::error(null, 'Invalid Input');
        }

        $service = Service::create([
            'name' => $fields['name'],
            'space' => $fields['space'],
            'capacity' => $fields['capacity'],
            'description' => $fields['description'],
        ]);

        return ResponseFormatter::success(
            $service,
            'New service created.'
        );
    }

    public function show($id)
    {
        try {
            $service = Service::findOrFail($id);
        } catch (Exception $e) {
            return ResponseFormatter::error(null, 'Service not found');
        }
        $service->load('images');
        $service->load('prices');
        $service->load('facilities');

        return ResponseFormatter::success(
            $service,
            'Get service success'
        );
    }
    public function update(Request $request, $id)
    {
        try {
            $fields = $request->validate([
                'name' => 'string|required|max:255',
                'space' => 'numeric|required',
                'capacity' => 'integer|required',
                'description' => 'nullable|string',
            ]);
        } catch (Exception $e) {
            return ResponseFormatter::error(null, 'Invalid Input');
        }
        try {
            $model = Service::findOrFail($id);
        } catch (Exception $e) {
            return ResponseFormatter::error(null, 'Service id not found');
        }
        $model->update($fields);
        return ResponseFormatter::success(
            $model,
            'Service updated'
        );
    }

    public function destroy($id)
    {
        try {
            $service = Service::findOrFail($id);
        } catch (Exception $e) {
            return ResponseFormatter::error(null, 'Service id not found');
        }
        $service->prices()->delete();
        $service->images()->delete();
        $service->delete();

        return ResponseFormatter::success(
            null,
            'Serive deleted.'
        );
    }
}
