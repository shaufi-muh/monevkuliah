<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SesiEvaluasi;
use App\Models\Mahasiswa;
use App\Models\Kuisioner;
use App\Models\Pertanyaan;
use App\Models\MataKuliah;
use App\Models\Kelas;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        // 1. Validasi Input dari Form (Server-side)
        $request->validate([
            'token' => 'required|string',
            'jawaban' => 'required|array',
            'jawaban.*.*.*' => 'required', // Memastikan setiap pertanyaan dijawab
        ], [
            'jawaban.*.*.*.required' => 'Semua pertanyaan wajib diisi.' // Custom error message
        ]);

        // 2. Validasi Token & Status
        $token = $request->input('token');
        $evaluasiToken = SesiEvaluasi::where('token_utama', $token)->first();

        $statusExists = DB::table('status_evaluasi')->where('sesi_evaluasi_id', $evaluasiToken->id ?? null)->exists();

        if (!$evaluasiToken || $statusExists) {
            return back()->withErrors(['token' => 'Token tidak valid atau sesi evaluasi ini telah selesai.']);
        }

        // 3. Ambil data jawaban dari request
        $jawabanData = $request->input('jawaban');
        $pertanyaanIds = []; // INISIALISASI VARIABLE
        foreach ($jawabanData as $matkuls) {
            foreach ($matkuls as $pertanyaans) {
                $pertanyaanIds = array_merge($pertanyaanIds, array_keys($pertanyaans));
            }
        }
        $pertanyaanTipeMap = Pertanyaan::whereIn('id', array_unique($pertanyaanIds))->pluck('tipe_jawaban', 'id');

        // Ambil semua ID matkul dan dosen pengampunya sekali saja
        $matkulIds = [];
        foreach ($jawabanData as $matkuls) {
            $matkulIds = array_merge($matkulIds, array_keys($matkuls));
        }
        $matkulsWithDosen = MataKuliah::with('dosenPengampu')->whereIn('id', array_unique($matkulIds))->get()->keyBy('id');

        // 4. Siapkan data untuk bulk insert
        $bulkJawaban = [];
        $now = now();

        foreach ($jawabanData as $kelasId => $matkuls) {
            foreach ($matkuls as $matkulId => $pertanyaans) {
                $dosenIds = $matkulsWithDosen->get($matkulId)->dosenPengampu->pluck('id')->all();
                if (empty($dosenIds)) {
                    $dosenIds = [null]; // Tetap proses meski tidak ada dosen, untuk jawaban yg tidak terkait dosen
                }

                foreach ($pertanyaans as $pertanyaanId => $value) {
                    $tipeJawaban = $pertanyaanTipeMap->get($pertanyaanId);
                    if (!$tipeJawaban) continue; // Lewati jika pertanyaan tidak ditemukan

                    foreach ($dosenIds as $dosenId) {
                        $bulkJawaban[] = [
                            'pertanyaan_id'    => $pertanyaanId,
                            'dosen_id'         => $dosenId,
                            'matakuliah_id'    => $matkulId,
                            'jawaban_boolean'  => $tipeJawaban == 'boolean' ? $value : 0,
                            'jawaban_numerik'  => $tipeJawaban == 'numerik' ? $value : null,
                            'jawaban_text'     => $tipeJawaban == 'text' ? $value : null,
                            'jawaban_tanggal'  => $tipeJawaban == 'tanggal' ? $value : null,
                            'sesi_evaluasi_id' => $evaluasiToken->id,
                            'created_at'       => $now,
                            'updated_at'       => $now,
                        ];
                    }
                }
            }
        }

        // 5. Simpan semua jawaban & tandai sesi sebagai selesai
        if (!empty($bulkJawaban)) {
            \App\Models\Jawaban::insert($bulkJawaban);
        }

        // Buat record di status_evaluasi untuk menandai sesi ini selesai
        DB::table('status_evaluasi')->insert([
            'sesi_evaluasi_id' => $evaluasiToken->id,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 6. Redirect ke halaman sukses
        return view('evaluasi.sukses');
    }

    /**
     * Display the specified resource.
     */
    public function show($token)
    {
        // 1. Validasi token
        $evaluasiToken = SesiEvaluasi::where('token_utama', $token)->firstOrFail();

        // 2. Cek apakah evaluasi untuk sesi ini sudah pernah diisi
        $statusExists = DB::table('status_evaluasi')->where('sesi_evaluasi_id', $evaluasiToken->id)->exists();
        if ($statusExists) {
            // Jika ingin menampilkan halaman khusus, buat view-nya. Abort lebih simpel.
            return abort(403, 'Terima kasih, Anda sudah menyelesaikan evaluasi untuk sesi ini.');
        }

        // 3. Ambil data yang relevan dari token
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
