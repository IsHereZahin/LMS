<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\FaqController;
use App\Http\Controllers\API\NoteController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\SectionController;
use App\Http\Controllers\API\LectureController;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
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
});
