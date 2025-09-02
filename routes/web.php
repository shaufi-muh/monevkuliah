<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Prodi\DosenController; // Sesuaikan dengan lokasi controller Anda
use App\Http\Controllers\Prodi\MataKuliahController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    // Logika setelah login bisa dipindahkan ke controller khusus jika perlu
    $user = auth()->user();
    if ($user->role === 'akademik') {
        return redirect()->route('akademik.dashboard');
    } elseif ($user->role === 'jurusan') {
        return redirect()->route('jurusan.dashboard');
    } elseif ($user->role === 'prodi') {
        return redirect()->route('prodi.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grup Rute untuk AKADEMIK
/*Route::middleware(['auth', 'role:akademik'])->prefix('akademik')->name('akademik.')->group(function () {
    Route::get('/dashboard', function () {
        return view('akademik.dashboard'); // Buat view di resources/views/akademik/dashboard lainnya di sini
});*/

// Grup Rute untuk JURUSAN
Route::middleware(['auth', 'role:jurusan'])->prefix('jurusan')->name('jurusan.')->group(function () {
    Route::get('/dashboard', function () {
        return view('jurusan.dashboard'); // Buat view di resources/views/jurusan/dashboard.blade.php
    })->name('dashboard');
    // Tambahkan rute jurusan lainnya di sini
});

// Grup Rute untuk PRODI
Route::middleware(['auth', 'role:prodi'])->prefix('prodi')->name('prodi.')->group(function () {
    Route::get('/dashboard', function () {
        return view('prodi.dashboard'); // Buat view di resources/views/prodi/dashboard.blade.php
    })->name('dashboard');

    Route::get('/dosen', [DosenController::class, 'index'])->name('dosen.index');
    Route::post('/dosen', [DosenController::class, 'store'])->name('dosen.store');
    Route::get('/matakuliah', [MataKuliahController::class, 'index'])->name('matakuliah.index');
    // Tambahkan rute prodi lainnya di sini
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
