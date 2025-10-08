<?php

use Illuminate\Support\Facades\Route;

// Definisikan rute-rute yang terkait dengan otentikasi di sini
// Contoh:
Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
