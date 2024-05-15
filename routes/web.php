<?php


use App\Http\Controllers\UserController;
use App\Http\Controllers\SendMSG;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/send', [SendMSG::class, 'sendMSG']);
Route::get("verify/{token}", [UserController::class, "verifyByEmail"]);

Route::get('/api/reset-password/{token}', [UserController::class, 'passwordResetForm']);
Route::post("/api/reset-password-submit", [UserController::class, "passwordResetSubmit"]);

