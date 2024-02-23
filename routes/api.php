<?php

use App\Http\Controllers\Api\AttendanceManagerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthentificateController;
use App\Http\Controllers\Api\EmployeeController;

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


Route::group(
    ['prefix' => 'v1',],
    function () {
        //Register
        Route::post('/register', [AuthentificateController::class, 'register']);
        Route::post('/login', [AuthentificateController::class, 'login']);
        Route::post('/forgot/password', [AuthentificateController::class, 'forgotPassword']);



        Route::group(['middleware' => ['auth:sanctum']], function () {
            Route::post('/logout', [AuthentificateController::class, 'logout']);
            Route::apiResource('/employee', EmployeeController::class);
            Route::post('/attendance/arrive',[AttendanceManagerController::class,'AttendanceArrive']);
            Route::post('/attendance/leave/{employeeAttendance}',[AttendanceManagerController::class,'AttendanceLeave']);
            Route::get('/attendance/pdf',[AttendanceManagerController::class,'attendancePdf']);
            Route::get('/attendance/csv',[AttendanceManagerController::class,'attendanceCsv']);        });
    }
);
