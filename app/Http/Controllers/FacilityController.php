<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facility;
use App\Helpers\ResponseFormatter;
use App\Exception;
use Exception as GlobalException;
use Throwable;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
            'name' => 'required|string',
            'description' => 'string',
        ]);

        if (!$fields) {
            return ResponseFormatter::error(
                null,
                'Invalid input',
                400
            );
        }

        //return $fields;
        $growth = Facility::create([
            'name' => $fields['name'],
            'description' => $fields['description']
        ]);

        return ResponseFormatter::success(
            $growth,
            'New facility added'
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
            $price = Facility::findOrFail($id);
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
                'Facility not found'
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
            'name' => 'required|string',
            'description' => 'string',
        ]);

        $model = Facility::find($id);
        $model->update($fields);


        return ResponseFormatter::success(
            $model,
            'Facility updated'
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
            $facility = Facility::find($id);
            $facility->delete();
            if ($facility) {
                return ResponseFormatter::success(
                    null,
                    'Facility deleted'
                );
            }
        } catch (GlobalException $e) {
            report($e);
            return ResponseFormatter::error(
                report($e),
                'Facility not found, cannot delete'
            );
        }
    }
}
