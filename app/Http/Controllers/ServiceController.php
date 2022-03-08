<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Helpers\ResponseFormatter;

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
        return $services;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $request = new Service();
        $request->name = "Meeting Room";
        $request->space = 10.0;
        $request->capacity = 10;
        $request->description = "This is the unique meeting room";
        $request->save();
        redirect('service');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = new Service();
        $model->name = $request->name;
        $model->space = $request->space;
        $model->capacity = $request->capacity;
        $model->description = $request->description;
        $model->save();
        redirect('service/');
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
        return $service;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Service::find($id);
        return view('service.edit', compact('model'));
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
        $request->validate([
            'name' => 'required',
            'space' => 'required',
            'capacity' => 'required',
            'description',
        ]);

        $model = Service::find($id);
        $model->name = $request->name;
        $model->space = $request->space;
        $model->capacity = $request->capacity;
        $model->description = $request->description;
        $model->save();
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
        $model->delete();
    }
}
