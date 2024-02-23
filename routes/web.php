<?php

use App\Http\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/reset/password/{token}', [ResetPasswordController::class, "viewResetPassword"])->name('user.reset');
Route::post('/reset/password/{token}', [ResetPasswordController::class, "postResetPassword"])->name('user.reset.post');
