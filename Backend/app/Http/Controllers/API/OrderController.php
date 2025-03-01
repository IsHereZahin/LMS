<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        // Load orders with their relationships
        $orders = Order::with(['user', 'course'])->latest()->get();

        // Return in a format compatible with the Vue component
        return response()->json(['orders' => ['data' => $orders]]);
    }

    /**
     * Store a new order.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'payment_method' => 'required|string',
            'transaction_id' => 'required|string|unique:orders,transaction_id',
        ]);

        $course = Course::findOrFail($validated['course_id']);
        $discountedPrice = max($course->price - $course->discount, 0); // Ensure price is not negative

        $order = Order::create([
            'user_id' => Auth::id(),
            'course_id' => $course->id,
            'amount' => $discountedPrice,
            'payment_method' => $validated['payment_method'],
            'transaction_id' => $validated['transaction_id'],
            'payment_status' => 'pending',
        ]);

        return response()->json(['message' => 'Order created successfully', 'order' => $order], 201);
    }

    /**
     * Update order status.
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'payment_status' => 'required|in:pending,completed,failed',
        ]);

        $order = Order::findOrFail($id);
        $order->payment_status = $validated['payment_status'];
        $order->save();

        return response()->json(['message' => 'Order status updated successfully', 'order' => $order]);
    }

    /**
     * Enroll in a free course.
     */
    public function enrollFree(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        $course = Course::findOrFail($validated['course_id']);

        if ($course->price > 0) {
            return response()->json(['message' => 'This course is not free'], 400);
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'course_id' => $course->id,
            'amount' => 0,
            'payment_method' => 'free',
            'transaction_id' => 'free-' . uniqid(),
            'payment_status' => 'completed',
        ]);

        return response()->json(['message' => 'Enrolled in free course successfully', 'order' => $order], 201);
    }

    /**
     * Check if a user has purchased a course.
     */
    public function checkPurchase($courseId)
    {
        $order = Order::where('user_id', Auth::id())
                    ->where('course_id', $courseId)
                    ->where('payment_status', 'completed')
                    ->latest()
                    ->first();

        return response()->json([
            'purchased' => (bool) $order,
            'order' => $order ?? null
        ]);
    }
}
