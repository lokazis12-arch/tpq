<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role === 'guru') {
            return redirect()->route('guru.dashboard');
        } elseif ($user->role === 'wali_santri') {
            return redirect()->route('wali.dashboard');
        }
    }
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Guru Routes
    Route::middleware('role:guru')->prefix('guru')->name('guru.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\GuruController::class, 'dashboard'])->name('dashboard');
        
        // Data Santri
        Route::get('/santri', [\App\Http\Controllers\GuruController::class, 'santriIndex'])->name('santri.index');
        Route::post('/santri', [\App\Http\Controllers\GuruController::class, 'santriStore'])->name('santri.store');
        Route::delete('/santri/{id}', [\App\Http\Controllers\GuruController::class, 'santriDestroy'])->name('santri.destroy');
        
        // Absensi
        Route::get('/absensi', [\App\Http\Controllers\GuruController::class, 'absensiIndex'])->name('absensi.index');
        Route::post('/absensi', [\App\Http\Controllers\GuruController::class, 'absensiStore'])->name('absensi.store');
        Route::delete('/absensi/{id}', [\App\Http\Controllers\GuruController::class, 'absensiDestroy'])->name('absensi.destroy');
        
        // Progres Iqro
        Route::get('/iqro', [\App\Http\Controllers\GuruController::class, 'iqroIndex'])->name('iqro.index');
        Route::post('/iqro', [\App\Http\Controllers\GuruController::class, 'iqroStore'])->name('iqro.store');
        Route::delete('/iqro/{id}', [\App\Http\Controllers\GuruController::class, 'iqroDestroy'])->name('iqro.destroy');

        // Progres Sholat
        Route::get('/sholat', [\App\Http\Controllers\GuruController::class, 'sholatIndex'])->name('sholat.index');
        Route::post('/sholat', [\App\Http\Controllers\GuruController::class, 'sholatStore'])->name('sholat.store');
        Route::delete('/sholat/{id}', [\App\Http\Controllers\GuruController::class, 'sholatDestroy'])->name('sholat.destroy');

        // Pembayaran
        Route::get('/pembayaran', [\App\Http\Controllers\GuruController::class, 'pembayaranIndex'])->name('pembayaran.index');
        Route::post('/pembayaran', [\App\Http\Controllers\GuruController::class, 'pembayaranStore'])->name('pembayaran.store');
        Route::delete('/pembayaran/{id}', [\App\Http\Controllers\GuruController::class, 'pembayaranDestroy'])->name('pembayaran.destroy');
    });

    // Wali Santri Routes
    Route::middleware('role:wali_santri')->prefix('wali')->name('wali.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\WaliController::class, 'dashboard'])->name('dashboard');
        Route::get('/switch-santri/{id}', [\App\Http\Controllers\WaliController::class, 'switchSantri'])->name('switch-santri');
        
        // Profile Management
        Route::get('/profile', [\App\Http\Controllers\WaliController::class, 'profile'])->name('profile');
        Route::post('/profile', [\App\Http\Controllers\WaliController::class, 'updateProfile'])->name('profile.update');
        Route::post('/change-password', [\App\Http\Controllers\WaliController::class, 'changePassword'])->name('change-password');
        
        Route::middleware('check.payment')->group(function () {
            Route::get('/iqro', [\App\Http\Controllers\WaliController::class, 'iqro'])->name('iqro');
            Route::get('/sholat', [\App\Http\Controllers\WaliController::class, 'sholat'])->name('sholat');
            Route::get('/presensi', [\App\Http\Controllers\WaliController::class, 'presensi'])->name('presensi');
            Route::get('/laporan', [\App\Http\Controllers\WaliController::class, 'laporan'])->name('laporan');
        });
    });
});
