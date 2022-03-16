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
        // $fields = $request->validate([
        //     'name' => 'string|required',
        //     'space' => 'double|required',
        //     'capacity' => 'integer|required',
        //     'description' => 'string',
        // ]);

        return $request;

        // if (!$fields) {
        //     return ResponseFormatter::error(
        //         null,
        //         'Invalid input.',
        //         400
        //     );
        // }

        // $service = Service::create([
        //     'name' => $fields['name'],
        //     'space' => $fields['space'],
        //     'capacity' => $fields['capacity'],
        //     'description' => $fields['description'],
        // ]);

        // return ResponseFormatter::success(
        //     $service,
        //     'New service created.'
        // );
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
