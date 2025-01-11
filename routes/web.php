<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\UserController;

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

// Mengubah route '/' menjadi redirect ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Tambahkan route ini
Route::get('/home', function () {
    return redirect()->route('wilayah.index');
});

// Route untuk auth yang tidak memerlukan authentication
Route::middleware(['guest', 'web'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Route untuk admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    // Routes untuk manajemen petugas
    Route::get('/petugas', [AdminController::class, 'showPetugas'])->name('admin.petugas.index');
    Route::get('/petugas/create', [AdminController::class, 'createPetugas'])->name('admin.petugas.create');
    Route::post('/petugas', [AdminController::class, 'storePetugas'])->name('admin.petugas.store');
    
    // Route untuk login history
    Route::get('/login-history', [AdminController::class, 'loginHistory'])->name('admin.login-history');
    
    // Routes untuk manajemen petugas
    Route::get('/petugas/{id}/edit', [AdminController::class, 'editPetugas'])->name('admin.petugas.edit');
    Route::put('/petugas/{id}', [AdminController::class, 'updatePetugas'])->name('admin.petugas.update');
    Route::get('/petugas/{id}', [AdminController::class, 'showDetailPetugas'])->name('admin.petugas.detail');
    Route::delete('/petugas/{id}', [AdminController::class, 'destroyPetugas'])->name('admin.petugas.destroy');

    // Routes untuk manajemen wilayah
    Route::get('/wilayah', [AdminController::class, 'indexWilayah'])->name('admin.wilayah.index');
    Route::get('/wilayah/create', [AdminController::class, 'createWilayah'])->name('admin.wilayah.create');
    Route::post('/wilayah', [AdminController::class, 'storeWilayah'])->name('admin.wilayah.store');
    Route::get('/wilayah/{id}/edit', [AdminController::class, 'editWilayah'])->name('admin.wilayah.edit');
    Route::put('/wilayah/{id}', [AdminController::class, 'updateWilayah'])->name('admin.wilayah.update');
    Route::delete('/wilayah/{id}', [AdminController::class, 'destroyWilayah'])->name('admin.wilayah.destroy');
    Route::get('/wilayah/{id}/show', [AdminController::class, 'showWilayah'])->name('admin.wilayah.show');
    Route::get('/wilayah/map', [AdminController::class, 'showMap'])->name('admin.wilayah.map');
    Route::put('/wilayah/{id}/details', [AdminController::class, 'updateDetails'])->name('admin.wilayah.details.update');
    Route::post('/wilayah/{id}/documents', [AdminController::class, 'storeDocument'])->name('admin.wilayah.documents.store');
    Route::delete('/wilayah/documents/{id}', [AdminController::class, 'destroyDocument'])->name('admin.wilayah.documents.destroy');

    // Route untuk statistik
    Route::get('/statistics', [AdminController::class, 'statistics'])->name('admin.statistics');

    // Di dalam group admin
    Route::get('/activity-logs', [AdminController::class, 'activityLogs'])->name('admin.activity-logs');
    Route::post('/wilayah/import', [AdminController::class, 'importWilayah'])->name('admin.wilayah.import');

    // Route untuk wilayah
    Route::get('/wilayah/export', [AdminController::class, 'exportWilayah'])->name('admin.wilayah.export');

    // Routes untuk manajemen user
    Route::resource('users', UserController::class);
});

// Route untuk user biasa
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Route untuk petugas
Route::middleware(['auth', 'petugas'])->prefix('petugas')->group(function () {
    Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('petugas.dashboard');
    Route::get('/wilayah/edit', [PetugasController::class, 'editWilayah'])->name('petugas.wilayah.edit');
    Route::put('/wilayah/update', [PetugasController::class, 'updateWilayah'])->name('petugas.wilayah.update');
    
    // Route baru untuk fitur tambahan
    Route::get('/penduduk', [PetugasController::class, 'indexPenduduk'])->name('petugas.penduduk.index');
    Route::get('/penduduk/create', [PetugasController::class, 'createPenduduk'])->name('petugas.penduduk.create');
    Route::post('/penduduk', [PetugasController::class, 'storePenduduk'])->name('petugas.penduduk.store');
    Route::get('/penduduk/{id}/edit', [PetugasController::class, 'editPenduduk'])->name('petugas.penduduk.edit');
    Route::put('/penduduk/{id}', [PetugasController::class, 'updatePenduduk'])->name('petugas.penduduk.update');
    
    // Route untuk laporan
    Route::get('/laporan', [PetugasController::class, 'indexLaporan'])->name('petugas.laporan.index');
    Route::post('/laporan', [PetugasController::class, 'storeLaporan'])->name('petugas.laporan.store');
    
    // Route untuk dokumen wilayah
    Route::get('/dokumen', [PetugasController::class, 'indexDokumen'])->name('petugas.dokumen.index');
    Route::post('/dokumen', [PetugasController::class, 'storeDokumen'])->name('petugas.dokumen.store');
});

// Route untuk user umum
Route::middleware(['auth'])->group(function () {
    Route::get('/wilayah', [WilayahController::class, 'index'])->name('wilayah.index');
    Route::get('/wilayah/{id}', [WilayahController::class, 'show'])->name('wilayah.show');
});
