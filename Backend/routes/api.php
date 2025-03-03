<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\FaqController;
use App\Http\Controllers\API\NoteController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\SectionController;
use App\Http\Controllers\API\LectureController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\CourseProgressController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Course routes
Route::get('get-courses', [CourseController::class, 'index']);
Route::get('/course/{id}', [CourseController::class, 'show']);

// Auth routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/myOrders', [OrderController::class, 'myOrders']);
    Route::post('/enroll-free', [OrderController::class, 'enrollFree']);
    Route::get('/check-purchase/{courseId}', [OrderController::class, 'checkPurchase']);

    Route::get('/myCourses', [CourseController::class, 'myCourses']);
    Route::get('/course-progress/show/{courseId}', [CourseProgressController::class, 'show']);
    Route::post('/course-progress/update/{courseId}', [CourseProgressController::class, 'update']);
});

// Admin Middleware Group
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    // Course routes
    Route::apiResource('courses', CourseController::class);

    // Section routes
    Route::get('courses/{courseId}/sections', [SectionController::class, 'index']);
    Route::apiResource('sections', SectionController::class)->except(['index']);

    // Lecture routes
    Route::get('sections/{sectionId}/lectures', [LectureController::class, 'index']);
    Route::apiResource('lectures', LectureController::class)->except(['index']);

    // Note routes
    Route::get('sections/{sectionId}/notes', [NoteController::class, 'index']);
    Route::apiResource('notes', NoteController::class)->except(['index']);

    // FAQ routes
    Route::get('courses/{courseId}/faqs', [FaqController::class, 'index']);
    Route::apiResource('faqs', FaqController::class)->except(['index']);

    // Order management routes
    Route::get('/orders', [OrderController::class, 'index']);
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']);
});
