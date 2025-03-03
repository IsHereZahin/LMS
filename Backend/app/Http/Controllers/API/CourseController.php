<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::where('publish', true)->latest()->get();
        return response()->json([
            'success' => true,
            'data' => $courses
        ]);
    }

    public function myCourses()
    {
        $userId = Auth::id();

        $courses = Course::whereIn('id', function ($query) use ($userId) {
            $query->select('course_id')
                ->from('orders')
                ->where('user_id', $userId)
                ->where('payment_status', 'completed');
        })->with('progress')->get();

        $courses->transform(function ($course) {
            return [
                'id' => $course->id,
                'title' => $course->title,
                'category' => $course->category,
                'level' => $course->level,
                'thumbnail' => $course->thumbnail,
                'price' => $course->price,
                'discount' => $course->discount,
                'discount_ends_at' => $course->discount_ends_at,
                'publish' => $course->publish,
                'certificate' => $course->certificate,
                'progress_percentage' => $course->progress ? $course->progress->progress_percentage : 0, // Ensure progress is included
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $courses
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'language' => 'required|string|max:255',
            'certificate' => 'boolean',
            'what_you_learn' => 'required|array',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'discount_ends_at' => 'nullable|date',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'duration' => 'nullable|integer',
            'level' => 'required|in:Beginner,Intermediate,Advanced',
            'publish' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');

        $course = Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'language' => $request->language,
            'certificate' => $request->certificate ?? false,
            'what_you_learn' => json_encode($request->what_you_learn),
            'price' => $request->price,
            'discount' => $request->discount,
            'discount_ends_at' => $request->discount_ends_at,
            'thumbnail' => $thumbnailPath,
            'duration' => $request->duration,
            'level' => $request->level,
            'publish' => $request->publish ?? false
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Course created successfully',
            'data' => $course
        ], 201);
    }

    public function show($id)
    {
        $course = Course::with(['sections.lectures', 'sections.notes', 'faqs'])->findOrFail($id);

        if (is_string($course->what_you_learn)) {
            $course->what_you_learn = json_decode($course->what_you_learn);
        }

        return response()->json([
            'status' => 'success',
            'data' => $course
        ]);
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'language' => 'required|string|max:255',
            'certificate' => 'boolean',
            'what_you_learn' => 'required|array',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'discount_ends_at' => 'nullable|date',
            'thumbnail' => 'nullable',
            'duration' => 'nullable|integer',
            'level' => 'required|in:Beginner,Intermediate,Advanced',
            'publish' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'language' => $request->language,
            'certificate' => $request->certificate ?? false,
            'what_you_learn' => json_encode($request->what_you_learn),
            'price' => $request->price,
            'discount' => $request->discount,
            'discount_ends_at' => $request->discount_ends_at,
            'duration' => $request->duration,
            'level' => $request->level,
            'publish' => $request->publish ?? false
        ];

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if it exists
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }

            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $data['thumbnail'] = $thumbnailPath;
        } else {
            // Retain the old thumbnail
            $data['thumbnail'] = $course->thumbnail;
        }

        $course->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Course updated successfully',
            'data' => $course
        ]);
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);

        // Delete thumbnail
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }

        $course->delete();

        return response()->json([
            'success' => true,
            'message' => 'Course deleted successfully'
        ]);
    }
}
