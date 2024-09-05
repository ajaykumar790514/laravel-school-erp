<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthenticationController;
use App\Http\Controllers\Api\ParentsApiController;
use App\Http\Controllers\Api\TeacherApiController;

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

Route::controller(AuthenticationController::class)->group(function () {
        Route::match(array('GET', 'POST'), 'login', 'login');
       
    });
    
    
Route::middleware(['token'])->group(function () {
    Route::controller(AuthenticationController::class)->group(function () {
        Route::match(array('GET', 'POST'), 'logout', 'logout');
        Route::match(array('GET', 'POST'), 'home', 'home');
    });
    Route::controller(ParentsApiController::class)->group(function () {
        Route::match(array('GET', 'POST'), 'children', 'children');
        Route::match(array('POST'), 'dashboard-daily-diary', 'dashboard_daily_diary');
        Route::match(array('POST'), 'dashboard-invoice', 'dashboard_invoice');
        Route::match(array('POST'), 'invoice-details', 'invoice_details');
        Route::match(array('POST'), 'student-profile', 'student_profile');
        Route::match(array('POST'), 'daily-diary-all', 'daily_diary_all');
        Route::match(array('POST'), 'assignment-all', 'assignment_all');
        Route::match(array('POST'), 'invoice-all', 'invoice_all');
        Route::match(array('POST'), 'notice-all', 'notice_all');
        Route::match(array('POST'), 'events-all', 'events_all');
    });
    
    Route::controller(TeacherApiController::class)->group(function () {
        Route::match(array('GET', 'POST'), 'teacher-dashboard', 'teacher_dashboard');
        Route::match(array('GET', 'POST'), 'teacher-dailydiary-all', 'teacher_dailydiary_all');
        
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



/*Route::middleware('auth:sanctum')->group( function () {
    Route::controller(AuthenticationController::class)->group(function () {
        //Route::match(array('GET', 'POST'), 'login', 'login');
        Route::match(array('GET', 'POST'), '/', 'login');
        Route::match(array('GET', 'POST'), 'home', 'home');
        Route::match(array('GET', 'POST'), 'index', 'login');
    });
});*/
