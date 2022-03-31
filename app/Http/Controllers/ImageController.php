<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Helpers\ResponseFormatter;
use Exception;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        try {
            $fields = $request->validate([
                'image_url' => 'required|string',
                'description' => 'nullable|string',
                'service_id' => 'required',
            ]);
        } catch (Exception $e) {
            return ResponseFormatter::error(null, 'Invalid input');
        }
        try {
            $image = Image::create([
                'image_url' => $fields['image_url'],
                'description' => $fields['description'],
                'service_id' => $fields['service_id'],
            ]);
        } catch (Exception $e) {
            return ResponseFormatter::error(null, 'Failed to add image');
        }

        return ResponseFormatter::success(
            $image,
            'New image added'
        );
    }
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
            return ResponseFormatter::error(null, 'Image not found');
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $fields = $request->validate([
                'image_url' => 'required|string',
                'description' => 'nullable|string',
                'service_id' => 'required',
            ]);
        } catch (Exception $e) {
            return ResponseFormatter::error(null, 'Invalid input');
        }

        try {
            $model = Image::findOrFail($id);
        } catch (Exception $e) {
            return ResponseFormatter::error(null, 'Image not found');
        }
        $model->update($fields);
        return ResponseFormatter::success(
            $model,
            'Image updated'
        );
    }

    public function destroy($id)
    {
        try {
            $image = Image::findOrFail($id);
        } catch (Exception $e) {
            report($e);
            return ResponseFormatter::error(null, 'Image can not deleted');
        }
        $image->delete();
        return ResponseFormatter::success('Image deleted');
    }
}
