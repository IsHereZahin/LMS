<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LectureController extends Controller
{
    public function index($sectionId)
    {
        $lectures = Lecture::where('section_id', $sectionId)->get();

        return response()->json([
            'success' => true,
            'data' => $lectures
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'section_id' => 'required|exists:sections,id',
            'title' => 'required|string|max:255',
            'duration' => 'required|integer',
            'youtube_video_id' => 'nullable|string|max:255',
            'is_premium' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $lecture = Lecture::create([
            'section_id' => $request->section_id,
            'title' => $request->title,
            'duration' => $request->duration,
            'youtube_video_id' => $request->youtube_video_id,
            'is_premium' => $request->is_premium ?? false
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Lecture created successfully',
            'data' => $lecture
        ], 201);
    }

    public function show($id)
    {
        $lecture = Lecture::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $lecture
        ]);
    }

    public function update(Request $request, $id)
    {
        $lecture = Lecture::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'duration' => 'required|integer',
            'youtube_video_id' => 'nullable|string|max:255',
            'is_premium' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $lecture->update([
            'title' => $request->title,
            'duration' => $request->duration,
            'youtube_video_id' => $request->youtube_video_id,
            'is_premium' => $request->is_premium ?? false
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Lecture updated successfully',
            'data' => $lecture
        ]);
    }

    public function destroy($id)
    {
        $lecture = Lecture::findOrFail($id);
        $lecture->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lecture deleted successfully'
        ]);
    }
}
