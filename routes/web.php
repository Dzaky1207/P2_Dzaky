<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\PasienController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->name('welcome');

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

// Pasien
Route::get('/Pasien', [PasienController::class, 'index'])->name('Pasien.pasien');
route::get('/Pasien/create', [PasienController::class, 'create'])->name('Pasien.create');
Route::get('/Pasien/edit/{id}', [PasienController::class, 'edit'])
    ->name('Pasien.edit');
Route::post('/pasien/antrian/{kode_pasien}', [PasienController::class, 'masukAntrian'])->name('Pasien.antrian');
route::put('/Pasien/update/{id}', [PasienController::class, 'update'])->name('Pasien.update');
route::post('/Pasien/store', [PasienController::class, 'store'])->name('Pasien.store');
route::delete('/Pasien/{id}', [PasienController::class, 'destroy'])->name('Pasien.destroy');

require __DIR__ . '/auth.php';
