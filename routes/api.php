<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\AdminController;

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

Route::get('v1/universities', [UniversityController::class, 'index']);
Route::get('v1/universities/{name}', [UniversityController::class, 'show']);
Route::post('v1/auth/admin/signup', [AdminController::class, 'signup']);
Route::post('v1/auth/admin/signin', [AdminController::class, 'signin']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('v1/universities', [UniversityController::class, 'store']);
    Route::patch('v1/universities/{id}', [UniversityController::class, 'update']);
    Route::delete('v1/universities/{id}', [UniversityController::class, 'destroy']);
    Route::post('v1/auth/admin/signout', [AdminController::class, 'signout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
