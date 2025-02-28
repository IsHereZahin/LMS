<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    public function index($courseId)
    {
        $faqs = Faq::where('course_id', $courseId)->get();

        return response()->json([
            'success' => true,
            'data' => $faqs
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'question' => 'required|string',
            'answer' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $faq = Faq::create([
            'course_id' => $request->course_id,
            'question' => $request->question,
            'answer' => $request->answer
        ]);

        return response()->json([
            'success' => true,
            'message' => 'FAQ created successfully',
            'data' => $faq
        ], 201);
    }

    public function show($id)
    {
        $faq = Faq::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $faq
        ]);
    }

    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'question' => 'required|string',
            'answer' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer
        ]);

        return response()->json([
            'success' => true,
            'message' => 'FAQ updated successfully',
            'data' => $faq
        ]);
    }

    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return response()->json([
            'success' => true,
            'message' => 'FAQ deleted successfully'
        ]);
    }
}

