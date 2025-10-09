<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Jurusan\DataProdiController;
use App\Http\Controllers\Jurusan\UserProdiController;
use App\Http\Controllers\Jurusan\TahunAkademikController;
use App\Http\Controllers\Jurusan\KuisionerController;
use App\Http\Controllers\Jurusan\PertanyaanController;
use App\Http\Controllers\Jurusan\BroadcastController;
use App\Http\Controllers\Jurusan\LaporanController;
use App\Http\Controllers\Prodi\DosenController;
use App\Http\Controllers\Prodi\MahasiswaController;
use App\Http\Controllers\Prodi\MataKuliahController;
use App\Http\Controllers\Prodi\KelasController;
use App\Http\Controllers\Prodi\IsiKelasController;
use App\Http\Controllers\EvaluasiController; // <-- Tambahkan ini




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
    Route::get('/dashboard', [TahunAkademikController::class, 'dashboard'])->name('dashboard');
    // Tambahkan rute jurusan lainnya di sini

    Route::resource('dataprodi', DataProdiController::class);
    Route::resource('userprodi', UserProdiController::class);
    Route::resource('kuisioner', KuisionerController::class); // <-- Tambahkan ini
    Route::patch('kuisioner/{kuisioner}/toggle-status', [KuisionerController::class, 'toggleStatus'])->name('kuisioner.toggleStatus');
    Route::resource('pertanyaan', PertanyaanController::class); // <-- Tambahkan ini
    Route::resource('tahun-akademik', TahunAkademikController::class); // <-- Tambahkan ini
    // Rute baru untuk toggle status tahun
    Route::patch('tahun-akademik/{tahun_akademik}/toggle-status', [TahunAkademikController::class, 'toggleStatus'])->name('tahun-akademik.toggleStatus');

    // Rute untuk menampilkan halaman formulir broadcast
    Route::get('/broadcast', [BroadcastController::class, 'index'])->name('broadcast.index');

    // Rute untuk memproses pengiriman form (action)
    Route::post('/broadcast/send', [BroadcastController::class, 'send'])->name('broadcast.send');

    Route::resource('laporan', LaporanController::class);
});

// Grup Rute untuk PRODI
Route::middleware(['auth', 'role:prodi'])->prefix('prodi')->name('prodi.')->group(function () {
    Route::get('/dashboard', function () {
        return view('prodi.dashboard');
    })->name('dashboard');

    Route::post('/dashboard/pbl', function() {
        $user = auth()->user();
        $prodi = \App\Models\Prodi::find($user->prodi_id ?? null);
        if ($prodi) {
            $prodi->pbl_applied = request('pbl_applied') === 'YA' ? 'YA' : 'TIDAK';
            $prodi->save();
        }
        return response()->json(['status' => $prodi ? $prodi->pbl_applied : 'TIDAK']);
    })->name('dashboard.pbl');


    Route::resource('dosen', DosenController::class);
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::resource('matakuliah', MataKuliahController::class);
    Route::resource('datakelas', KelasController::class)->parameters(['datakelas' => 'kela']);

    Route::get('isikelas', [IsiKelasController::class, 'index'])->name('isikelas.index');
    Route::get('isikelas/{kelas}', [IsiKelasController::class, 'show'])->name('isikelas.show');
    Route::post('isikelas/{kelas}/add', [IsiKelasController::class, 'addMahasiswa'])->name('isikelas.add');
    Route::post('isikelas/{kelas}/remove', [IsiKelasController::class, 'removeMahasiswa'])->name('isikelas.remove');

    // Mata kuliah pada kelas
    Route::post('isikelas/{kelas}/add-matkul', [IsiKelasController::class, 'addMataKuliah'])->name('isikelas.addMatkul');
    Route::post('isikelas/{kelas}/remove-matkul', [IsiKelasController::class, 'removeMataKuliah'])->name('isikelas.removeMatkul');
    
    //Route::get('/dosen', [DosenController::class, 'index'])->name('dosen.index');
    //Route::post('/dosen', [DosenController::class, 'store'])->name('dosen.store');
    //Route::get('/matakuliah', [MataKuliahController::class, 'index'])->name('matakuliah.index');

    // Tambahkan rute prodi lainnya di sini
});

// Rute untuk mahasiswa mengisi evaluasi
Route::get('/evaluasi/{token}', [EvaluasiController::class, 'show'])->name('evaluasi.show');
Route::post('/evaluasi/simpan', [EvaluasiController::class, 'store'])->name('evaluasi.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
