<?php

namespace App\Http\Controllers\Jurusan;

use App\Http\Controllers\Controller;
use App\Models\Kuisioner;
use App\Models\Prodi;
use App\Models\User; // Asumsi prodi ada di tabel user
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BroadcastController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jurusanId = Auth::user()->jurusan_id;

        // 1. Cari SATU-SATUNYA kuisioner yang sedang aktif
        $kuisionerAktif = Kuisioner::where('jurusan_id', $jurusanId)
                                    ->where('status', 'aktif')
                                    ->first();

        // 2. Ambil SEMUA prodi di bawah naungan jurusan ini
        $prodiList = Prodi::where('jurusan_id', $jurusanId)
                          ->orderBy('nama_prodi', 'asc')
                          ->get();

        // 3. Kirim kedua data tersebut ke view
        return view('jurusan.broadcast.index', compact('kuisionerAktif', 'prodiList'));
    
    }

    public function send(Request $request)
    {
        // 1. Validasi Input (Antisipasi Error)
        $validatedData = $request->validate([
            'kuisioner_id'   => 'required|exists:kuisioners,id',
            'semester_label' => 'required|string|max:100',
            'prodi_ids'      => 'required|array|min:1', // Memastikan minimal satu prodi dipilih
            'prodi_ids.*'    => 'exists:prodi,id',     // Memastikan setiap ID prodi valid
        ], [
            // Pesan error kustom dalam Bahasa Indonesia
            'kuisioner_id.required'   => 'Tidak ada kuisioner yang aktif untuk dikirim.',
            'semester_label.required' => 'Kolom semester wajib diisi.',
            'prodi_ids.required'      => 'Anda harus memilih minimal satu Program Studi.',
        ]);

        // Jika validasi berhasil, kita akan lanjutkan di sini.
        // Untuk sekarang, kita hentikan dan lihat dulu data yang tervalidasi.
        dd($validatedData);

        // TODO: Langkah selanjutnya adalah:
        // 1. Mencari mahasiswa berdasarkan semester_label dan prodi_ids.
        // 2. Generate token unik untuk setiap mahasiswa.
        // 3. Menampilkan halaman konfirmasi dengan daftar link.

        return back()->with('success', 'Proses pengiriman tautan evaluasi sedang berjalan di latar belakang.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
