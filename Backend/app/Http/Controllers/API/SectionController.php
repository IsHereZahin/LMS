<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SectionController extends Controller
{
    public function index($courseId)
    {
        $sections = Section::where('course_id', $courseId)
            ->with(['lectures', 'notes'])
            ->get();

        return response()->json([
            'success' => true,
            'data' => $sections
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $section = Section::create([
            'course_id' => $request->course_id,
            'title' => $request->title
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Section created successfully',
            'data' => $section
        ], 201);
    }

    public function show($id)
    {
        $section = Section::with(['lectures', 'notes'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $section
        ]);
    }

    public function update(Request $request, $id)
    {
        $section = Section::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $section->update([
            'title' => $request->title
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Section updated successfully',
            'data' => $section
        ]);
    }

    public function destroy($id)
    {
        $section = Section::findOrFail($id);
        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Section deleted successfully'
        ]);
    }
}

