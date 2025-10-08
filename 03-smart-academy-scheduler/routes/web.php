 <?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminTIController;
use App\Http\Controllers\AdminPTIController;
use App\Http\Controllers\AdminPTEController;
use App\Http\Controllers\AdminTRSEController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\ConstraintsController;
use App\Services\GeneticScheduler;
use Illuminate\Support\Facades\DB;
use App\Models\ConstraintsDosen; 
use App\Models\ConstraintsRuang; 
use App\Models\RuangKelas; 


Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [LoginController::class, 'login']); // Handles login POST
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/adminti', [AdminTIController::class, 'index'])->name('adminti.index1');
Route::post('/adminti/verifikasi-massal', [AdminTIController::class, 'verifikasiMassal'])->name('adminti.verifikasi-massal');
Route::get('/adminti/show/{kode_mk}', [AdminTIController::class, 'show'])->name('adminti.show');
Route::get('/adminti/save_datati', [AdminTIController::class, 'saveDatati'])->name('adminti.save_datati');


Route::get('/adminti/create', [AdminTIController::class, 'create'])->name('adminti.create');

Route::post('/adminti', [AdminTIController::class, 'store'])->name('adminti.store');

Route::get('/adminti/{id}', [AdminTiController::class, 'edit'])->name('adminti.edit');
Route::get('/adminti/{id}/update', [AdminTiController::class, 'update'])->name('adminti.update');
Route::get('/adminti/update/{id}', [AdminTIController::class, 'formUpdate'])->name('adminti.form_update');
Route::put('/adminti/update/{id}', [AdminTIController::class, 'update'])->name('adminti.update');
Route::get('/adminti/edit', [AdminTIController::class, 'edit'])->name('adminti.edit');
Route::get('/admin-ti/insert', [AdminTIController::class, 'create'])->name('adminti.insert');
Route::delete('/reset-data-ti', [AdminTIController::class, 'resetData'])->name('reset.save_data_ti');
Route::get('/admin-ti/jadwal', [ScheduleController::class, 'index2'])->name('jadwal.adminti');

Route::delete('/adminti/{id}', [AdminTIController::class, 'destroy'])->name('adminti.destroy');
Route::get('/adminpti', [AdminPTIController::class, 'index2'])->name('adminpti.index2');
Route::get('/adminpti/show/{id}', [AdminPTIController::class, 'show'])->name('adminpti.show');
Route::get('/adminpti/insert', [AdminPTIController::class, 'create'])->name('adminpti.insert');
Route::post('/adminpti/store', [AdminPTIController::class, 'store'])->name('adminpti.store');
Route::get('/adminpti/edit', [AdminPTIController::class, 'edit'])->name('adminpti.edit');
Route::get('/adminpti/update/{id}', [AdminPTIController::class, 'formUpdate'])->name('adminpti.form_update');
Route::put('/adminpti/update/{id}', [AdminPTIController::class, 'update'])->name('adminpti.update');
Route::delete('/adminpti/delete/{id}', [AdminPTIController::class, 'destroy'])->name('adminpti.destroy');
Route::post('/adminpti/verifikasi-massal', [AdminPTIController::class, 'verifikasiMassal'])->name('adminpti.verifikasi-massal');
Route::get('/adminpti/save_datapti', [AdminPTIController::class, 'saveDatapti'])->name('adminpti.save_datapti');
Route::get('/admin-pti/jadwal', [ScheduleController::class, 'index3'])->name('jadwal.adminpti');

Route::get('/adminpte', [AdminPTEController::class, 'index3'])->name('adminpte.index3');
Route::get('/adminpte/show/{id}', [AdminPTEController::class, 'show'])->name('adminpte.show');
Route::get('/adminpte/insert', [AdminPTEController::class, 'create'])->name('adminpte.insert');
Route::post('/adminpte/store', [AdminPTEController::class, 'store'])->name('adminpte.store');
Route::get('/adminpte/edit', [AdminPTEController::class, 'edit'])->name('adminpte.edit');
Route::get('/adminpte/update/{id}', [AdminPTEController::class, 'formUpdate'])->name('adminpte.form_update');
Route::put('/adminpte/update/{id}', [AdminPTEController::class, 'update'])->name('adminpte.update');
Route::delete('/adminpte/delete/{id}', [AdminPTEController::class, 'destroy'])->name('adminpte.destroy');
Route::post('/adminpte/verifikasi-massal', [AdminPTEController::class, 'verifikasiMassal'])->name('adminpte.verifikasi-massal');
Route::get('/adminpte/save_datapte', [AdminPTEController::class, 'saveDatapte'])->name('adminpte.save_datapte');
Route::get('/admin-pte/jadwal', [ScheduleController::class, 'index4'])->name('jadwal.adminpte');


Route::get('/admintrse', [AdminTRSEController::class, 'index4'])->name('admintrse.index4');
Route::get('/admintrse/show/{id}', [AdminTRSEController::class, 'show'])->name('admintrse.show');
Route::get('/admintrse/insert', [AdminTRSEController::class, 'create'])->name('admintrse.insert');
Route::post('/admintrse/store', [AdminTRSEController::class, 'store'])->name('admintrse.store');
Route::get('/admintrse/edit', [AdminTRSEController::class, 'edit'])->name('admintrse.edit');
Route::get('/admintrse/update/{id}', [AdminTRSEController::class, 'formUpdate'])->name('admintrse.form_update');
Route::put('/admintrse/update/{id}', [AdminTRSEController::class, 'update'])->name('admintrse.update');
Route::delete('/admintrse/delete/{id}', [AdminTRSEController::class, 'destroy'])->name('admintrse.destroy');
Route::get('/admin-trse/jadwal', [ScheduleController::class, 'index5'])->name('jadwal.admintrse');
Route::post('/admintrse/verifikasi-massal', [AdminTRSEController::class, 'verifikasiMassal'])->name('admintrse.verifikasi-massal');
Route::get('/admintrse/save_datatrse', [AdminTRSEController::class, 'saveDatatrse'])->name('admintrse.save_datatrse');
Route::prefix('superadmin')->name('superadmin.')->group(function () {

    Route::get('/superadmin', [SuperAdminController::class, 'index'])->name('index');
    Route::get('/create', [SuperAdminController::class, 'create'])->name('create');
    Route::post('/', [SuperAdminController::class, 'store'])->name('store');
    Route::get('/{user}/edit', [SuperAdminController::class, 'edit'])->name('edit');
    Route::put('/{user}', [SuperAdminController::class, 'update'])->name('update');
    Route::delete('/{user}', [SuperAdminController::class, 'destroy'])->name('destroy');
});


Route::get('/superadmin/ruang', [SuperAdminController::class, 'ruangIndex'])->name('superadmin.ruangIndex');
Route::get('/get-matkul-by-kode/{kode_mk}', [ConstraintsController::class, 'getMatkulByKode']);
Route::get('/superadmin/ruang/create', [SuperAdminController::class, 'ruangCreate'])->name('superadmin.ruangCreate');
Route::post('/superadmin/ruang/store', [SuperAdminController::class, 'ruangStore'])->name('superadmin.ruangStore');
Route::get('/superadmin/ruang/edit/{ruang_kelas}', [SuperAdminController::class, 'ruangEdit'])->name('superadmin.ruangEdit');
Route::put('/superadmin/ruang/update/{ruang_kelas}', [SuperAdminController::class, 'ruangUpdate'])->name('superadmin.ruangUpdate');
Route::delete('/superadmin/ruang/delete/{ruang_kelas}', [SuperAdminController::class, 'ruangDestroy'])->name('superadmin.ruangDestroy');

Route::get('/superadmin/kelas', [SuperAdminController::class, 'kelasIndex'])->name('superadmin.kelasIndex');
Route::get('/superadmin/kelas/create', [SuperAdminController::class, 'kelasCreate'])->name('superadmin.kelasCreate');
Route::get('/get-kode-seksi/{kode_seksi}', [SuperAdminController::class, 'getKodeSeksi'])->name('superadmin.getKodeSeksi');
Route::post('/superadmin/kelas/store', [SuperAdminController::class, 'kelasStore'])->name('superadmin.kelasStore');
Route::get('/superadmin/kelas/store', [SuperAdminController::class, 'kelasStore'])->name('superadmin.kelasStore'); // <-- HAPUS INI
Route::get('/superadmin/kelas/edit/{kelas}', [SuperAdminController::class, 'kelasEdit'])->name('superadmin.kelasEdit');
Route::put('/superadmin/kelas/update/{kelas}', [SuperAdminController::class, 'kelasUpdate'])->name('superadmin.kelasUpdate');
Route::delete('/superadmin/kelas/delete/{kelas}', [SuperAdminController::class, 'kelasDestroy'])->name('superadmin.kelasDestroy');


Route::prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/constraints', function () {
        return view('superadmin.constraints.index');
    })->name('constraints.index');

    Route::get('/constraints/dosen', [ConstraintsController::class, 'dosen'])->name('constraints.dosen');
    Route::get('/constraints/dosen/insert', [ConstraintsController::class, 'showDosenInsert'])->name('constraints.dosen_insert');
    Route::post('/constraints/dosen/insert', [ConstraintsController::class, 'DosenStore'])->name('constraints.dosen_store');
    Route::delete('/constraints/dosen/delete/{id}', [ConstraintsController::class, 'destroyDosen'])->name('constraints.dosen_delete');

    Route::get('/constraints/ruangan', [ConstraintsController::class, 'ruangan'])->name('constraints.ruangan');
    Route::get('/constraints/ruangan/insert', [ConstraintsController::class, 'showRuanganInsert'])->name('constraints.ruangan_insert');
    Route::post('/constraints/ruangan/insert', [ConstraintsController::class, 'RuanganStore'])->name('constraints.ruangan_store');
    Route::delete('/constraints/ruangan/delete/{id}', [ConstraintsController::class, 'destroyRuangan'])->name('constraints.ruangan_delete');


    Route::get('/constraints/group', [ConstraintsController::class, 'group'])->name('constraints.group');
    Route::get('/constraints/group/insert', [ConstraintsController::class, 'showGroupInsert'])->name('constraints.group_insert');
    Route::post('/constraints/group/insert', [ConstraintsController::class, 'GroupStore'])->name('constraints.group_store');
    Route::delete('/constraints/group/delete/{id}', [ConstraintsController::class, 'destroyGroup'])->name('constraints.group_delete');
});

Route::get('/superadmin/jam', [SuperAdminController::class, 'jam'])->name('superadmin.jam');

Route::get('/jadwal', [ScheduleController::class, 'index'])->name('jadwal.index');
Route::post('/jadwal/generate', [ScheduleController::class, 'generate'])->name('jadwal.generate');
Route::post('/jadwal/reset', [ScheduleController::class, 'reset'])->name('jadwal.reset');

Route::get('/test-genetic-accuracy', function() {
    
});