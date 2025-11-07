<?php

use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

// Root route - show login page (or redirect to welcome if already logged in)
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');

// Welcome page (protected route - requires authentication)
Route::get('/welcome', [CalculatorController::class, 'index'])->middleware('auth')->name('welcome');

// Calculator API routes
Route::post('/calculator/store', [CalculatorController::class, 'store'])->middleware('auth')->name('calculator.store');
Route::get('/calculator/history', [CalculatorController::class, 'history'])->middleware('auth')->name('calculator.history');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
