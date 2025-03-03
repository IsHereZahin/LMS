<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseProgress;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class CourseProgressController extends Controller
{
    /**
     * Display the user's progress for a specific course
     */
    public function show($courseId)
    {
        $user = auth()->user();

        // Get the course to verify it exists
        $course = Course::findOrFail($courseId);

        // Check the user course purchase
        $purchaseStatus = Order::where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->where('payment_status', 'completed')
            ->exists();

        // If purchase status is not completed, return error
        if (!$purchaseStatus) {
            return response()->json([
                'success' => false,
                'message' => 'You must complete the purchase to track progress.'
            ], 403);
        }

        // Get or create progress record
        $progress = CourseProgress::firstOrCreate(
            [
                'user_id' => $user->id,
                'course_id' => $courseId
            ],
            [
                'completed_lessons' => json_encode([]),
                'progress_percentage' => '0'
            ]
        );

        // Get total number of lectures in the course
        $totalLectures = Lecture::whereHas('section', function($query) use ($courseId) {
            $query->where('course_id', $courseId);
        })->count();

        return response()->json([
            'success' => true,
            'data' => [
                'progress' => $progress,
                'total_lectures' => $totalLectures
            ]
        ]);
    }

    /**
     * Update the user's progress for a specific course
     */
    public function update(Request $request, $courseId)
    {
        $user = auth()->user();

        // Check if the user has completed the course purchase
        $purchaseStatus = Order::where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->where('payment_status', 'completed')
            ->exists();

        // If purchase status is not completed, return error
        if (!$purchaseStatus) {
            return response()->json([
                'success' => false,
                'message' => 'You must complete the purchase to update progress.'
            ], 403);
        }

        // Validate request
        $request->validate([
            'lecture_id' => 'required|exists:lectures,id',
            'completed' => 'required|boolean'
        ]);

        // Get lecture to verify it belongs to the course
        $lecture = Lecture::with('section')->findOrFail($request->lecture_id);

        // Verify lecture belongs to the course
        if ($lecture->section->course_id != $courseId) {
            return response()->json([
                'success' => false,
                'message' => 'Lecture does not belong to this course'
            ], 400);
        }

        // Get or create progress record
        $progress = CourseProgress::firstOrCreate(
            [
                'user_id' => $user->id,
                'course_id' => $courseId
            ],
            [
                'completed_lessons' => json_encode([]),
                'progress_percentage' => '0'
            ]
        );

        // Get completed lessons array
        $completedLessons = json_decode($progress->completed_lessons, true) ?: [];

        // Update completed lessons
        if ($request->completed && !in_array($request->lecture_id, $completedLessons)) {
            $completedLessons[] = $request->lecture_id;
        } elseif (!$request->completed && in_array($request->lecture_id, $completedLessons)) {
            $completedLessons = array_diff($completedLessons, [$request->lecture_id]);
        }

        // Get total number of lectures in the course
        $totalLectures = Lecture::whereHas('section', function($query) use ($courseId) {
            $query->where('course_id', $courseId);
        })->count();

        // Calculate progress percentage
        $progressPercentage = $totalLectures > 0
            ? round((count($completedLessons) / $totalLectures) * 100, 2)
            : 0;

        // Update progress
        $progress->completed_lessons = json_encode($completedLessons);
        $progress->progress_percentage = (string) $progressPercentage;
        $progress->save();

        return response()->json([
            'success' => true,
            'data' => [
                'progress' => $progress,
                'total_lectures' => $totalLectures
            ]
        ]);
    }
}
