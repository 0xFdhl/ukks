<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\OwnerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'petugas') {
        return redirect()->route('petugas.dashboard');
    } elseif ($user->role === 'owner') {
        return redirect()->route('owner.dashboard');
    }

    return abort(403);
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==================== ADMIN ====================
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::resource('user', UserController::class);
        Route::resource('tarif', TarifController::class);
        Route::resource('area', AreaController::class);
        Route::resource('kendaraan', KendaraanController::class);

        Route::get('log', [LogController::class, 'index'])->name('log.index');
    });

    // ==================== PETUGAS ====================
    Route::middleware('role:petugas')->prefix('petugas')->name('petugas.')->group(function () {
        Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('dashboard');

        Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::post('/transaksi/masuk', [TransaksiController::class, 'masuk'])->name('transaksi.masuk');
        Route::post('/transaksi/keluar/{id}', [TransaksiController::class, 'keluar'])->name('transaksi.keluar');
        Route::get('/struk/{id}', [TransaksiController::class, 'struk'])->name('struk');
    });

    // ==================== OWNER ====================
    Route::middleware('role:owner')->prefix('owner')->name('owner.')->group(function () {
        Route::get('/dashboard', [OwnerController::class, 'dashboard'])->name('dashboard');
        Route::get('/rekap', [OwnerController::class, 'rekap'])->name('rekap');
    });

});

require __DIR__.'/auth.php';
