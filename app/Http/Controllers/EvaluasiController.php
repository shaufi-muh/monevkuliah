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
        // 1. Validasi token
        $token = $request->input('token');
        $evaluasiToken = EvaluasiToken::where('token', $token)->whereNull('digunakan_pada')->first();
        if (!$evaluasiToken) {
            return back()->withErrors(['token' => 'Token tidak valid atau sudah digunakan.']);
        }

        // 2. Ambil data jawaban dari request
        $jawabanData = $request->input('jawaban');
        if (!$jawabanData || !is_array($jawabanData)) {
            return back()->withErrors(['jawaban' => 'Jawaban tidak ditemukan.']);
        }

        // 3. Simpan semua jawaban secara anonim
        // Format: jawaban[kelas_id][matkul_id][pertanyaan_id] = value
        foreach ($jawabanData as $kelasId => $matkuls) {
            foreach ($matkuls as $matkulId => $pertanyaans) {
                foreach ($pertanyaans as $pertanyaanId => $value) {
                    // Ambil pertanyaan untuk tipe
                    $pertanyaan = \App\Models\Pertanyaan::find($pertanyaanId);
                    if (!$pertanyaan) continue;

                    // Ambil dosen pengampu dari matkul (bisa lebih dari satu, simpan satu-satu)
                    $matkul = \App\Models\MataKuliah::find($matkulId);
                    if (!$matkul) continue;
                    $dosenPengampu = $matkul->dosenPengampu;
                    if ($dosenPengampu->isEmpty()) {
                        // Jika tidak ada dosen, tetap simpan dengan dosen_id null
                        $dosenIds = [null];
                    } else {
                        $dosenIds = $dosenPengampu->pluck('id')->toArray();
                    }
                    foreach ($dosenIds as $dosenId) {
                        \App\Models\Jawaban::create([
                            'pertanyaan_id'    => $pertanyaanId,
                            'dosen_id'         => $dosenId,
                            'matakuliah_id'    => $matkulId,
                            'real_pertemuan'   => 0, // Jika ada input real pertemuan, ambil dari request
                            'jawaban_boolean'  => $pertanyaan->tipe_jawaban == 'boolean' ? $value : null,
                            'keterangan'       => $pertanyaan->tipe_jawaban == 'numerik' ? $value : null,
                        ]);
                    }
                }
            }
        }

        // 4. Tandai token sebagai sudah digunakan
        $evaluasiToken->digunakan_pada = now();
        $evaluasiToken->save();

        // 5. Redirect dengan pesan sukses
        return redirect()->route('evaluasi.show', $token)->with('success', 'Jawaban evaluasi berhasil disimpan. Terima kasih!');
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
    
        // a. Cari tahu tahun akademik aktif yang relevan untuk evaluasi ini
        // (Kita bisa ambil dari data mahasiswa_semesters)
        $tahunAkademikAktif = TahunAkademik::where('jurusan_id', $kuisioner->jurusan_id)
                                         ->where('status', 'aktif')
                                         ->first(); // ... Logika untuk mendapatkan tahun akademik aktif terkait evaluasi
        if (!$tahunAkademikAktif) {
            // Anda bisa menampilkan view error yang lebih ramah di sini jika mau.
            abort(503, 'Saat ini tahun akademik belum ada yang aktif. Silakan hubungi administrator.');
        }
        // b. Ambil semua kelas yang diikuti oleh mahasiswa INI pada semester AKTIF ITU
        // Ini membutuhkan relasi yang tepat di Model Mahasiswa
            $kelasYangDiikuti = $mahasiswa->kelasTahunAkademik($tahunAkademikAktif->id)
                ->with('mataKuliahs.dosenPengampu') // Eager load relasi dosen pengampu dari mata kuliah
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
