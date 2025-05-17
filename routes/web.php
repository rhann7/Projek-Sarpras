<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [UserController::class, 'auth'])->name('auth');
Route::post('/login', [UserController::class, 'login'])->name('login');