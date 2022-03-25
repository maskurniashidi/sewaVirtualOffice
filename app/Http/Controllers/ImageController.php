<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Helpers\ResponseFormatter;
use Exception;

class ImageController extends Controller
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
            'image_url' => 'required|string',
            'description' => 'string',
            'service_id' => 'required',
        ]);

        if (!$fields) {
            return ResponseFormatter::error(
                null,
                'Invalid input',
                400
            );
        }

        $growth = Image::create([
            'image_url' => $fields['image_url'],
            'description' => $fields['description'],
            'service_id' => $fields['service_id'],
        ]);

        return ResponseFormatter::success(
            $growth,
            'New iamge added'
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
            $image = Image::findOrFail($id);
            if ($image) {
                return ResponseFormatter::success(
                    $image,
                    'success'
                );
            }
        } catch (Exception $e) {
            report($e);
            return ResponseFormatter::error(
                report($e),
                'Image not found'
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
            'image_url' => 'required|string',
            'description' => 'string',
            'service_id' => 'required',
        ]);

        if (!$fields) {
            return ResponseFormatter::error(
                null,
                'Invalid input',
                400
            );
        } else {
            $model = Image::find($id);
            $model->update($fields);
            return ResponseFormatter::success(
                $model,
                'Image updated'
            );
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
            $image = Image::findOrFail($id);
            $image->delete();
            return ResponseFormatter::success(
                null,
                'Image deleted'
            );
        } catch (Exception $e) {
            report($e);
            return ResponseFormatter::error(
                report($e),
                'Image can not deleted'
            );
        }
    }
}
