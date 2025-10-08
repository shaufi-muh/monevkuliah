<?php

namespace App\Http\Controllers\Jurusan;

use App\Http\Controllers\Controller;
use App\Models\Kuisioner;
use App\Models\Prodi;
use App\Models\SesiEvaluasi;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http; // <-- DITAMBAHKAN

class BroadcastController extends Controller
{
    public function index()
    {
        $jurusanId = Auth::user()->jurusan_id;
        $kuisionerAktif = Kuisioner::where('jurusan_id', $jurusanId)
                                    ->where('status', 'aktif')
                                    ->first();
        $prodiList = Prodi::where('jurusan_id', $jurusanId)
                          ->orderBy('nama_prodi', 'asc')
                          ->get();
        return view('jurusan.broadcast.index', compact('kuisionerAktif', 'prodiList'));
    }

    // METHOD SEND DI REFACTOR TOTAL
    public function send(Request $request)
    {
        $validatedData = $request->validate([
            'kuisioner_id'   => 'required|exists:kuisioners,id',
            'prodi_ids'      => 'required|array|min:1',
            'prodi_ids.*'    => 'exists:prodis,id', // perbaikan typo prodi -> prodis
        ], [
            'kuisioner_id.required'   => 'Tidak ada kuisioner yang aktif untuk dikirim.',
            'prodi_ids.required'      => 'Anda harus memilih minimal satu Program Studi.',
        ]);

        $mahasiswaList = Mahasiswa::whereIn('prodi_id', $validatedData['prodi_ids'])
            ->whereHas('kelas') // Hanya mhs yang sudah punya kelas
            ->whereNotNull('no_telp') // Hanya mhs yang punya nomor telepon
            ->get();

        if ($mahasiswaList->isEmpty()) {
            return back()->with('error', 'Tidak ada mahasiswa yang memenuhi kriteria di program studi terpilih.');
        }

        $kuisioner = Kuisioner::find($validatedData['kuisioner_id']);
        $tahunAkademik = $kuisioner->tahun_akademik; // Asumsi kuisioner selalu ditemukan karena ada validasi 'exists'

        $payloadMessages = [];

        // --- LOOP SEKARANG HANYA SATU KALI ---
        foreach ($mahasiswaList as $mhs) {
            $token = bin2hex(random_bytes(16));

            // 1. Buat sesi evaluasi dengan token unik
            SesiEvaluasi::create([
                'mahasiswa_nim' => $mhs->nim,
                'kuisioner_id' => $kuisioner->id,
                'tahun_akademik' => $tahunAkademik, // Menggunakan ID tahun akademik
                'token_utama' => $token,
            ]);

            // 2. Siapkan pesan yang akan dikirim
            $pesan = "Halo {$mhs->nama}, silakan isi evaluasi kuliah semester ini melalui tautan berikut: " . url("/evaluasi/{$token}");

            // +++ PERBAIKAN FORMAT NOMOR TELEPON +++
            $nomorTujuan = $mhs->no_telp;
            if (substr($nomorTujuan, 0, 1) === '0') {
                $nomorTujuan = '62' . substr($nomorTujuan, 1);
            }

            // 3. Kumpulkan pesan ke dalam array untuk dikirim sekaligus
            $payloadMessages[] = [
                'to' => $nomorTujuan,
                'text' => $pesan,
            ];
        }

        // --- KIRIM SEMUA PESAN DALAM SATU KALI PANGGILAN HTTP ---
        try {
            $response = Http::post('http://localhost:5001/message/send-bulk', [
                'sessionId' => 'mysession', // atau session ID lain jika Anda menggunakan multi-session
                'messages' => $payloadMessages,
            ]);

            if ($response->failed()) {
                // Jika gateway merespon dengan error (4xx atau 5xx)
                return back()->with('error', 'Gagal mengirim pesan broadcast. Gateway WhatsApp memberikan respon error.');
            }

        } catch (\Exception $e) {
            // Jika tidak bisa konek ke gateway sama sekali
            return back()->with('error', 'Gagal terhubung ke WhatsApp Gateway. Pastikan gateway sedang berjalan.');
        }

        return back()->with('success', 'Proses pengiriman tautan evaluasi ke ' . count($payloadMessages) . ' mahasiswa berhasil dimulai.');
    }
    
    // Method lain tidak diubah
    public function create() {}
    public function store(Request $request) {}
    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
