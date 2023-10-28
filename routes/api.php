<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DormController;
use App\Http\Controllers\SpecialityController;

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

//Public University routes
Route::get('v1/universities', [UniversityController::class, 'index']);
Route::get('v1/universities/{name}', [UniversityController::class, 'show']);

//Public Admin routes
Route::post('v1/auth/admin/signup', [AdminController::class, 'signup']);
Route::post('v1/auth/admin/signin', [AdminController::class, 'signin']);

//Public Dorm routes
Route::get('v1/universities/dorms', [DormController::class, 'index']);
Route::get('v1/universities/dorms/{id}', [DormController::class, 'show']);

//Public Speciality routes
Route::get('v1/specialties', [SpecialityController::class, 'index']);
Route::get('v1/specialties/{id}', [SpecialityController::class, 'show']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    //Protected University routes
    Route::post('v1/universities', [UniversityController::class, 'store']);
    Route::patch('v1/universities/{id}', [UniversityController::class, 'update']);
    Route::delete('v1/universities/{id}', [UniversityController::class, 'destroy']);

    //Protected Admin routes
    Route::post('v1/auth/admin/signout', [AdminController::class, 'signout']);

    //Protected Dorm routes
    Route::post('v1/universities/{id}/dorms', [DormController::class, 'store']);
    Route::patch('v1/universities/{id}/dorms', [DormController::class, 'update']);
    Route::delete('v1/universities/dorms/{id}', [DormController::class, 'destroy']);

    //Protected Speciality routes
    Route::post('v1/specialties', [SpecialityController::class, 'store']);
    Route::patch('v1/specialties/{id}', [SpecialityController::class, 'update']);
    Route::delete('v1/specialties/{id}', [SpecialityController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
