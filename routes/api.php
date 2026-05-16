<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Course routes
// Route::get('/course/index', [CourseController::class, 'index'])->middleware('auth:sanctum');
// Route::post('/course/store', [CourseController::class, 'store'])->middleware(['auth:sanctum', 'admin']);
// Route::patch('/course/update/{id}', [CourseController::class, 'update'])->middleware(['auth:sanctum', 'admin']);
// Route::delete('course/delete/{id}', [CourseController::class, 'delete'])->middleware(['auth:sanctum', 'admin']);


// For loggedIn user
    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/course/index', [CourseController::class, 'index']);
    });


// admin ley chalauney route lai group gareko because harek route ma hamiley middlewre raknu parxa
Route::middleware(['auth:sanctum', 'admin'])->group(function(){
    Route::post('/course/store', [CourseController::class, 'store']);
    Route::patch('/course/update/{id}', [CourseController::class, 'update']);
    Route::delete('course/delete/{id}', [CourseController::class, 'delete']);
});


// Auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/profile', [AuthController::class, 'profile'])->middleware("auth:sanctum");
Route::get('/login', [AuthController::class, 'login_response'])->name('login');
Route::delete('/logout', [AuthController::class, 'logOut'])->middleware("auth:sanctum");    