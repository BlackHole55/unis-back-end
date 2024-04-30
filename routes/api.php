<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DormController;
use App\Http\Controllers\SpecialityController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\SpecialityUniversityController;

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

//Public routes
Route::prefix('v1')->group(function() {
    //University routes
    Route::prefix('universities')->group(function(){

        Route::get('/', [UniversityController::class, 'index']);
        Route::post('search', [UniversityController::class, 'search']);
        Route::get('{id}', [UniversityController::class, 'show']);

        //Dorm routes
        Route::get('dorms', [DormController::class, 'index']);
        Route::get('dorms/{id}', [DormController::class, 'show']);

        //Speciality University routes
        Route::get('speciality-university/{id}', [SpecialityUniversityController::class, 'show']);
    });

    //Admin routes
    Route::prefix('auth/admins')->group(function(){
        // Route::post('signup', [AdminController::class, 'signup']);
        Route::post('signin', [AdminController::class, 'signin']);
    });

    //Speciality routes
    Route::prefix('specialties')->group(function(){
        Route::get('/', [SpecialityController::class, 'index']);
        Route::get('{id}', [SpecialityController::class, 'show']);
    });

    //Exams routes
    Route::prefix('exams')->group(function(){
        Route::get('/', [ExamController::class, 'index']);
        Route::get('{id}', [ExamController::class, 'show']);
    });


    //Protected routes
    Route::group(['middleware' => ['auth:sanctum']], function () {
        //University routes
        Route::prefix('universities')->group(function(){

            Route::post('/', [UniversityController::class, 'store']);
            Route::patch('{id}', [UniversityController::class, 'update']);
            Route::delete('{id}', [UniversityController::class, 'destroy']);

            Route::post('{id}/specialties', [UniversityController::class, 'addSpeciality']);
            Route::delete('{id}/specialties', [UniversityController::class, 'removeSpeciality']);

            //Dorm routes
            Route::post('{id}/dorms', [DormController::class, 'store']);
            Route::patch('dorms/{id}', [DormController::class, 'update']);
            Route::delete('dorms/{id}', [DormController::class, 'destroy']);

            
            //SpecialitUniversity routes
            Route::post('speciality-university/{id}/exams', [SpecialityUniversityController::class, 'addExam']);
            Route::delete('speciality-university/{id}/exams', [SpecialityUniversityController::class, 'removeExam']);
        });

        //Admin routes
        Route::prefix('auth/admins')->group(function(){
            Route::post('signout', [AdminController::class, 'signout']);
            Route::get('check-login', [AdminController::class, 'checkLogin']);
        });


        //Speciality routes
        Route::prefix('specialties')->group(function(){
            Route::post('/', [SpecialityController::class, 'store']);
            Route::patch('{id}', [SpecialityController::class, 'update']);
            Route::delete('{id}', [SpecialityController::class, 'destroy']);
        });

        //Exams routes
        Route::prefix('exams')->group(function(){
            Route::post('/', [ExamController::class, 'store']);
            Route::patch('{id}', [ExamController::class, 'update']);
            Route::delete('{id}', [ExamController::class, 'destroy']);
        });
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
