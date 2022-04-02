<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Helpers\ResponseFormatter;
use Exception;
use Validator;

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
        $validator = Validator::make($request->all(),[
            'name' => 'string|required|max:255',
            'space' => 'numeric|required',
            'capacity' => 'integer|required',
            'description' => 'nullable|string',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());       
        }
        try{
            $service = Service::create([
                'name' => $request->name,
                'space' => $request->space,
                'capacity' => $request->capacity,
                'description' => $request->description,
            ]);
        }catch(Exception $e){
            return ResponseFormatter::error(
                report($e),
                'Failed to create new service'
            );
        }
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
        $validator = Validator::make($request->all(),[
            'name' => 'string|required|max:255',
            'space' => 'numeric|required',
            'capacity' => 'integer|required',
            'description' => 'nullable|string',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());       
        }
        try {
            $model = Service::findOrFail($id);
            $fields =[
                'name' => $request->name,
                'space'=>$request->space,
                'capacity'=>$request->capacity,
                'description'=>$request->description,
            ];
            $model->update($fields);
        } catch (Exception $e) {
            return ResponseFormatter::error(null, 'Service id not found');
        }
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
            'Service deleted.'
        );
    }
}
