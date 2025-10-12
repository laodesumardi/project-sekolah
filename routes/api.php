<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CalendarController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Calendar API Routes
Route::prefix('calendar')->group(function () {
    Route::get('/events', [CalendarController::class, 'getEvents']);
    Route::get('/events/{event}', [CalendarController::class, 'show']);
    
    // Admin only routes
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::post('/events', [CalendarController::class, 'store']);
        Route::put('/events/{event}', [CalendarController::class, 'update']);
        Route::delete('/events/{event}', [CalendarController::class, 'destroy']);
    });
});

