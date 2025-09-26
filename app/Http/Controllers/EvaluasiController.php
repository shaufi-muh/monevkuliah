<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EvaluasiToken;
use App\Models\Mahasiswa;
use App\Models\Kuisioner;
use App\Models\Pertanyaan;
use App\Models\MataKuliah;
use App\Models\Kelas;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show($token)
    {
        // 1. Validasi token
        $evaluasiToken = EvaluasiToken::where('token', $token)->whereNull('digunakan_pada')->firstOrFail();

        // 2. Ambil data yang relevan dari token
        $mahasiswa = $evaluasiToken->mahasiswa;
        $kuisioner = $evaluasiToken->kuisioner;
        
        // 3. Ambil semua pertanyaan dari kuisioner tersebut, urutkan berdasarkan 'urutan'
        $pertanyaans = $kuisioner->pertanyaans()->orderBy('urutan', 'asc')->get();
        
        // 4. LOGIKA FILTERISASI MATA KULIAH (YANG DISEMPURNAKAN)
    
        // a. Cari tahu semester aktif yang relevan untuk evaluasi ini
        // (Kita bisa ambil dari data mahasiswa_semesters)
        $semesterAktif = TahunAkademik::where('jurusan_id', $kuisioner->jurusan_id)
                                         ->where('status', 'aktif')
                                         ->first(); // ... Logika untuk mendapatkan semester aktif terkait evaluasi
        if (!$semesterAktif) {
            // Anda bisa menampilkan view error yang lebih ramah di sini jika mau.
            abort(503, 'Saat ini tidak ada sesi evaluasi yang aktif. Silakan hubungi administrator.');
        }
        // b. Ambil semua kelas yang diikuti oleh mahasiswa INI pada semester AKTIF ITU
        // Ini membutuhkan relasi yang tepat di Model Mahasiswa
        $kelasYangDiikuti = $mahasiswa->kelas()
                                    ->where('tahun_akademik_id', $semesterAktif->id)
                                    ->with('mataKuliah', 'dosen') // Ambil juga info matkul & dosen
                                    ->get();

        // 5. Kirim semua data ke view
        //return view('evaluasi.show', compact('evaluasiToken', 'mahasiswa', 'pertanyaans', 'mataKuliahs'));
        // 5. Kirim semua data ke view
        return view('evaluasi.show', [
            'evaluasiToken' => $evaluasiToken,
            'mahasiswa'     => $mahasiswa,
            'pertanyaans'   => $pertanyaans,
            'mataKuliahs'   => $kelasYangDiikuti, // Kirim data kelas yang sudah terfilter
        ]);
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
