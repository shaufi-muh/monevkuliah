<?php

namespace App\Http\Controllers\Jurusan;

use App\Http\Controllers\Controller;
use App\Models\Kuisioner;
use App\Models\Prodi;
use App\Models\User;
use App\Models\SesiEvaluasi;
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
        // Validasi input tanpa semester
        $validatedData = $request->validate([
            'kuisioner_id'   => 'required|exists:kuisioners,id',
            'prodi_ids'      => 'required|array|min:1',
            'prodi_ids.*'    => 'exists:prodi,id',
        ], [
            'kuisioner_id.required'   => 'Tidak ada kuisioner yang aktif untuk dikirim.',
            'prodi_ids.required'      => 'Anda harus memilih minimal satu Program Studi.',
        ]);

        // Ambil mahasiswa dari prodi terpilih YANG SUDAH TERGABUNG KE DALAM KELAS
        $mahasiswaList = \App\Models\Mahasiswa::whereIn('prodi_id', $validatedData['prodi_ids'])
            ->whereHas('kelas')
            ->get();

        // Generate token unik & simpan historis ke sesi_evaluasi
        $kuisioner = \App\Models\Kuisioner::find($validatedData['kuisioner_id']);
        $tahunAkademik = $kuisioner ? $kuisioner->tahun_akademik : null;

        foreach ($mahasiswaList as $mhs) {
            $token = bin2hex(random_bytes(16));
            SesiEvaluasi::create([
                'mahasiswa_nim' => $mhs->nim,
                'kuisioner_id' => $kuisioner->id,
                'tahun_akademik' => $tahunAkademik,
                'token_utama' => $token,
                // 'berlaku_hingga' => ... (isi jika ingin ada batas waktu)
            ]);
        }

        $client = new Client(); // Inisialisasi Guzzle

        foreach ($mahasiswaList as $mhs) {
            $token = bin2hex(random_bytes(16));
            SesiEvaluasi::create([
                'mahasiswa_nim' => $mhs->nim,
                'kuisioner_id' => $kuisioner->id,
                'tahun_akademik' => $tahunAkademik,
                'token_utama' => $token,
            ]);

            // Kirim pesan WhatsApp ke WA Gateway
            $payload = [
                'number' => $mhs->no_telp, // pastikan field nomor WA benar
                'message' => "Halo {$mhs->nama}, silakan isi evaluasi kuliah di tautan berikut: " . url("/evaluasi/{$token}")
            ];

            try {
                $client->post('http://localhost:5001/send-message', [
                    'json' => $payload
                ]);
            } catch (\Exception $e) {
                // Optional: log error atau tampilkan pesan gagal kirim
            }
        }

        return back()->with('success', 'Proses pengiriman tautan evaluasi dan pencatatan historis berhasil.');
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
