<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Response;
use App\Helpers\ResponseFormatter;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseFormatSame;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
            'name' => 'string|required|max:255',
            'space' => 'numeric|required',
            'capacity' => 'integer|required',
            'description' => 'string',
        ]);

        //return $fields;

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Service::findOrFail($id);
        $service->load('images');
        $service->load('prices');
        $service->load('facilities');
        if ($service) {
            return ResponseFormatter::success(
                $service,
                'Get service success'
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
            'name' => 'string|required|max:255',
            'space' => 'numeric|required',
            'capacity' => 'integer|required',
            'description' => 'string',
        ]);

        $model = Service::find($id);
        // return $model;
        $model->update($fields);

        if ($model) {
            return ResponseFormatter::success(
                $model,
                'Service updated'
            );
        } else {
            return ResponseFormatter::error(null, "Service failed to update", 400);
        }
        //return $fields;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Service::find($id);

        $model->prices()->delete();
        $model->images()->delete();
        $model->delete();

        return ResponseFormatter::success(
            null,
            'Serive deleted.'
        );
    }
}
