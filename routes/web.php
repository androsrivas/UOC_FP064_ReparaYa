<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'rol:admin'])->group(function () {
    
});

Route::middleware(['auth', 'rol:tecnico'])->group(function () {
    
});

Route::middleware(['auth', 'rol:gestora'])->group(function () {
    
});

Route::middleware(['auth', 'rol:particular'])->group(function () {
    
});
