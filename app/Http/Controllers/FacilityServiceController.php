<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Models\FacilityService;
use Exception;
use Throwable;

class FacilityServiceController extends Controller
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
        try {
            $fields = $request->validate([
                "service_id" => 'required',
                "facility_id" => 'required',
            ]);
        } catch (Exception $e) {
            return ResponseFormatter::error(
                null,
                'required service_id and facility_id'
            );
        }

        try {
            $growth = FacilityService::create([
                'service_id' => $fields['service_id'],
                'facility_id' => $fields['facility_id']
            ]);
        } catch (Exception $e) {
            return ResponseFormatter::error(
                null,
                'failed to create service facility'
            );
        }
        return ResponseFormatter::success(
            $growth,
            'New service facility added'
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
            $model = FacilityService::findOrFail($id);
        } catch (Exception $e) {
            return ResponseFormatter::error(
                null,
                'Service facility not found'
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
                "facility_id" => 'required',
            ]);
        } catch (Exception $e) {
            return ResponseFormatter::error(
                null,
                'required service_id and facility_id'
            );
        }

        try {
            $model = FacilityService::findOrFail($id);
            $model->update($fields);
        } catch (Exception $e) {
            return ResponseFormatter::error(
                null,
                'failed to update service facility'
            );
        }
        return ResponseFormatter::success(
            $model,
            'Service facility updated'
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
            $price = FacilityService::findOrFail($id);
            $price->delete();
            if ($price) {
                return ResponseFormatter::success(
                    null,
                    'services facility deleted'
                );
            }
        } catch (Throwable $e) {
            report($e);
            return ResponseFormatter::error(
                report($e),
                'Service facility not found, cannot delete'
            );
        }
    }
}
