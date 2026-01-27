<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\KelompokController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\TujuanController;
use App\Http\Controllers\SumberSuratController;
use App\Http\Controllers\TembusanController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::match(['put', 'patch'], '/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Staff
Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
Route::get('/staff/{id}/edit', [StaffController::class, 'edit'])->name('staff.edit');
Route::put('/staff/{id}', [StaffController::class, 'update'])->name('staff.update');
Route::delete('/staff/{id}', [StaffController::class, 'destroy'])->name('staff.destroy');

// Jenis
Route::get('jenis', [JenisController::class, 'index'])->name('jenis.index');
Route::get('jenis/view/{id}', [JenisController::class, 'show'])->name('jenis.view');
Route::get('jenis/create', [JenisController::class, 'create'])->name('jenis.create');
Route::post('jenis/store', [JenisController::class, 'store'])->name('jenis.store');
Route::delete('jenis/delete/{id}', [JenisController::class, 'destroy'])->name('jenis.delete');

// Kelompok
Route::get('kelompok', [KelompokController::class, 'index'])->name('kelompok.index');
Route::get('kelompok/create', [KelompokController::class, 'create'])->name('kelompok.create');
Route::get('kelompok/{id}/edit', [KelompokController::class, 'edit'])->name('kelompok.edit');
Route::post('kelompok/store', [KelompokController::class, 'store'])->name('kelompok.store');
Route::delete('kelompok/{id}', [KelompokController::class, 'destroy'])->name('kelompok.destroy');

// Sumber Surat
Route::get('sumber', [SumberSuratController::class, 'index'])->name('sumber.index');
Route::get('sumber/create', [SumberSuratController::class, 'create'])->name('sumber.create');
Route::get('sumber/{id}/edit', [SumberSuratController::class, 'edit'])->name('sumber.edit');
Route::post('sumber/store', [SumberSuratController::class, 'store'])->name('sumber.store');
Route::put('sumber/{id}', [SumberSuratController::class, 'update'])->name('sumber.update');
Route::delete('sumber/{id}', [SumberSuratController::class, 'destroy'])->name('sumber.destroy');

// Tujuan Surat
route::get('tujuan', [TujuanController::class, 'tujuan'])->name('tujuan.index');
Route::get('jenis/view/{id}', [JenisController::class, 'show'])->name('tujuan.view');
route::get('tujuan/create', [TujuanController::class, 'create'])->name('tujuan.create');
route::post('tujuan/store', [TujuanController::class, 'store'])->name('tujuan.store');
route::delete('tujuan/delete/{id}', [TujuanController::class, 'destroy'])->name('tujuan.destroy');

// ================= FORM =================
Route::get('/surat', [SuratController::class, 'index'])->name('surat.formsurat');
Route::get('/surat/create', [SuratController::class, 'create'])->name('surat.create');
Route::post('/surat/store', [SuratController::class, 'store'])->name('surat.store');

// ================= STORE =================
Route::post('/surat/storeMasuk', [SuratController::class, 'storeMasuk'])->name('surat.storeMasuk');
Route::post('/surat/storeKeluar', [SuratController::class, 'storeKeluar'])->name('surat.storeKeluar');

// ================= SURAT MASUK =================
Route::get('/surat/edit/masuk/{id}', [SuratController::class, 'editMasuk'])->name('surat.editMasuk');
Route::put('/surat/updateMasuk/{id}', [SuratController::class, 'updateMasuk'])->name('surat.updateMasuk');
Route::delete('/surat/delete/masuk/{id}', [SuratController::class, 'destroyMasuk'])->name('surat.destroyMasuk');

// ================= SURAT KELUAR =================
Route::get('/surat/edit/keluar/{id}', [SuratController::class, 'editKeluar'])->name('surat.editKeluar');
Route::put('/surat/updateKeluar/{id}', [SuratController::class, 'updateKeluar'])->name('surat.updateKeluar');
Route::delete('/surat/delete/keluar/{id}', [SuratController::class, 'destroyKeluar'])->name('surat.destroyKeluar');

// ================= LIST =================
Route::get('/surat/masuk', [SuratController::class, 'listMasuk'])->name('surat.masuk');
Route::get('/surat/keluar', [SuratController::class, 'listKeluar'])->name('surat.keluar');

// Tembusan
Route::get('tembusan', [TembusanController::class, 'tembusan'])->name('tembusan.tembusan');
Route::get('jenis/view/{id}', [TembusanController::class, 'show'])->name('tembusan.view');
route::get('tembusan/create', [TembusanController::class, 'create'])->name('tembusan.create');
route::post('tembusan/store', [TembusanController::class, 'store'])->name('tembusan.store');
route::delete('tembusan/delete/{id}', [TembusanController::class, 'destroy'])->name('tembusan.destroy');

// Rekap Surat
Route::get('/surat/formrekap', [SuratController::class, 'rekap'])->name('surat.formrekap');
Route::get('/surat/rekap', [SuratController::class, 'rekap'])->name('surat.rekap');

Route::get('/surat/cari', [SuratController::class, 'cari'])->name('surat.cari');

require __DIR__ . '/auth.php';
