<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\SuperAdminController;


// Rute untuk login
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [LoginController::class, 'login']); // Handles login POST
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/layanan', [LayananController::class, 'index'])->name('layanan');
Route::post('/layanan/store', [LayananController::class, 'store'])->name('layanan.store');


// Rute untuk data dan profil

Route::get('/profile', [ProfileController::class, 'profile'])->name('profile.show');

Route::get('/layanan/{nidn}', [LayananController::class, 'show'])->name('dosen.tampildata');

// Route to store data if applicable
Route::post('/layanan', [LayananController::class, 'store'])->name('layanan.store');
// Rute root untuk mengarahkan ke halaman login
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');


Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/show/{nidn}', [AdminController::class, 'showLayanan'])->name('admin.show');
Route::post('/admin/verifikasi', [AdminController::class, 'verifikasi'])->name('admin.verifikasi');
Route::get('/admin/approved', [AdminController::class, 'approved'])->name('admin.approved');
Route::get('/admin/rejected', [AdminController::class, 'rejected'])->name('admin.rejected');
Route::get('/admin/download-pdf/{nidn}', [AdminController::class, 'downloadPDF'])->name('admin.downloadPDF');
Route::get('/admin/view-pdf/{nidn}', [AdminController::class, 'viewPDF'])->name('admin.viewPDF');


Route::get('/rekapdata', [DataController::class, 'rekapData'])->name('rekapdata');
Route::get('/layanan/{id}', [DataController::class, 'showLayanan'])->name('rencana.kerja');
Route::get('/dokumen/{nidn}', [DataController::class, 'showDokumen'])->name('laporan.kinerja');
// web.php

Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('/manage-users', [SuperAdminController::class, 'index'])->name('manage.users');
    Route::post('/add-user', [SuperAdminController::class, 'addUser'])->name('add.user');
    Route::get('/update-users', [SuperAdminController::class, 'showUpdateUserPage'])->name('update-users');
    Route::post('/update-user/{nidn}', [SuperAdminController::class, 'updateUser'])->name('update.user');
    Route::delete('/delete-user/{nidn}', [SuperAdminController::class, 'deleteUser'])->name('delete.user');
    Route::get('/search-users', [SuperAdminController::class, 'searchUsers'])->name('search.users');    
});