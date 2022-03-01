<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/sign_up', [AuthController::class, 'sign_up']);
Route::post('/sign_in', [AuthController::class, 'sign_in']);

Route::post('/reset_password_token', [AuthController::class, 'reset_password']);
Route::post('/forgot_passowrd', [AuthController::class, 'sendPasswordResetToken']);
Route::post('/new_password', [AuthController::class, 'set_new_password']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('/category',CategoryController::class);
    Route::resource('/course',CourseController::class);

    // More routes here

});

