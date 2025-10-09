<?php

namespace App\Http\Controllers\Jurusan;

use App\Http\Controllers\Controller;
use App\Models\Pertanyaan;
use App\Models\Kelas;
use App\Models\Prodi;
use App\Models\TahunAkademik;
use App\Models\Jawaban;
use App\Models\SesiEvaluasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $jurusan_id = $user->jurusan_id;

        // 1. Ambil data untuk filter
        $prodis = \App\Models\Prodi::where('jurusan_id', $jurusan_id)->orderBy('nama_prodi')->get();
        $tahunAkademiks = \App\Models\TahunAkademik::orderBy('tahun_akademik', 'desc')->get();
        $prodiIds = $prodis->pluck('id');
        $mataKuliahs = \App\Models\MataKuliah::whereHas('kelas', function ($query) use ($prodiIds) {
            $query->whereIn('prodi_id', $prodiIds);
        })->orderBy('nama_matkul')->get();
        $dosens = \App\Models\Dosen::whereHas('prodi', function ($q) use ($jurusan_id) {
            $q->where('jurusan_id', $jurusan_id);
        })->orderBy('nama_dosen')->get();

        // 2. Ambil semua pertanyaan yang relevan
        $pertanyaans = \App\Models\Pertanyaan::whereHas('kuisioner', function ($query) use ($jurusan_id) {
            $query->where('jurusan_id', $jurusan_id);
        })->orderBy('urutan')->get();

        // 3. Query utama untuk mengambil jawaban berdasarkan filter
        $query = DB::table('jawabans')
            ->join('pertanyaans', 'jawabans.pertanyaan_id', '=', 'pertanyaans.id')
            ->join('sesi_evaluasi', 'jawabans.sesi_evaluasi_id', '=', 'sesi_evaluasi.id')
            ->join('mahasiswas', 'sesi_evaluasi.mahasiswa_nim', '=', 'mahasiswas.nim')
            ->join('prodis', 'mahasiswas.prodi_id', '=', 'prodis.id')
            ->join('kuisioners', 'sesi_evaluasi.kuisioner_id', '=', 'kuisioners.id')
            ->join('tahun_akademiks', function ($join) {
                $join->on('kuisioners.tahun_akademik', '=', 'tahun_akademiks.tahun_akademik')
                     ->on('kuisioners.semester', '=', 'tahun_akademiks.semester');
            })
            ->where('prodis.jurusan_id', $jurusan_id);

        if ($request->filled('prodi_id')) {
            $query->where('prodis.id', $request->prodi_id);
        }
        if ($request->filled('tahun_akademik_id')) {
            $query->where('tahun_akademiks.id', $request->tahun_akademik_id);
        }
        if ($request->filled('semester')) {
            $query->where('tahun_akademiks.semester', $request->semester);
        }
        if ($request->filled('matakuliah_id')) {
            $query->where('jawabans.matakuliah_id', $request->matakuliah_id);
        }
        if ($request->filled('dosen_id')) {
            $query->where('jawabans.dosen_id', $request->dosen_id);
        }

        $rawJawabans = $query->select(
            'jawabans.pertanyaan_id',
            'sesi_evaluasi.mahasiswa_nim as mahasiswa_identifier',
            'pertanyaans.tipe_jawaban',
            'jawabans.jawaban_numerik',
            'jawabans.jawaban_text',
            'jawabans.jawaban_boolean'
        )->get();

        // 4. Proses dan kelompokkan data jawaban
        $reportData = [];
        foreach ($pertanyaans as $pertanyaan) {
            $reportData[$pertanyaan->id] = [
                'isi_pertanyaan' => $pertanyaan->isi_pertanyaan,
                'tipe_jawaban' => $pertanyaan->tipe_jawaban,
                'total_responden' => 0,
                'answers' => [],
                'responden_ids' => [], // Array sementara untuk menghitung responden unik
            ];
        }

        foreach ($rawJawabans as $jawaban) {
            if (!isset($reportData[$jawaban->pertanyaan_id])) continue;

            $pertanyaan_id = $jawaban->pertanyaan_id;

            // Tambahkan identifier mahasiswa untuk dihitung nanti
            if (!in_array($jawaban->mahasiswa_identifier, $reportData[$pertanyaan_id]['responden_ids'])) {
                $reportData[$pertanyaan_id]['responden_ids'][] = $jawaban->mahasiswa_identifier;
            }

            // Kelompokkan jawaban berdasarkan tipenya
            $tipe = $jawaban->tipe_jawaban;
            if ($tipe == 'numerik') {
                $value = $jawaban->jawaban_numerik;
                if (!isset($reportData[$pertanyaan_id]['answers'][$value])) {
                    $reportData[$pertanyaan_id]['answers'][$value] = 0;
                }
                $reportData[$pertanyaan_id]['answers'][$value]++;
            } elseif ($tipe == 'text') {
                if (!empty($jawaban->jawaban_text)) {
                    $reportData[$pertanyaan_id]['answers'][] = $jawaban->jawaban_text;
                }
            } elseif ($tipe == 'boolean') {
                $value = $jawaban->jawaban_boolean ? 'Ada / Sesuai' : 'Tidak Ada / Tidak Sesuai';
                if (!isset($reportData[$pertanyaan_id]['answers'][$value])) {
                    $reportData[$pertanyaan_id]['answers'][$value] = 0;
                }
                $reportData[$pertanyaan_id]['answers'][$value]++;
            }
        }

        // 5. Hitung total responden unik dan bersihkan data
        foreach ($reportData as $pertanyaan_id => &$data) {
            $data['total_responden'] = count($data['responden_ids']);
            unset($data['responden_ids']); // Hapus array sementara

            if ($data['tipe_jawaban'] == 'numerik') {
                ksort($data['answers']); // Urutkan jawaban numerik dari 1, 2, 3, ...
            }
        }

        return view('jurusan.laporan.index', [
            'prodis' => $prodis,
            'tahunAkademiks' => $tahunAkademiks,
            'mataKuliahs' => $mataKuliahs,
            'dosens' => $dosens,
            'reportData' => $reportData,
            'request' => $request,
        ]);
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
