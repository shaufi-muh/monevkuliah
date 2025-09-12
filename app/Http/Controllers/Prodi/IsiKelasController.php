<?php

namespace App\Http\Controllers\Prodi;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // <-- Jangan lupa tambahkan ini di atas

class IsiKelasController extends Controller
{
    // Menampilkan halaman pilihan kelas
    public function index()
    {
        $kelasList = Kelas::where('prodi_id', Auth::user()->prodi->id)->get();
        return view('prodi.kelas.isikelas.index', compact('kelasList'));
    }

    // Menampilkan halaman manajemen (dua kolom)
    public function show(Kelas $kelas, Request $request)
    {
        // Pastikan prodi hanya bisa akses kelasnya sendiri (optional, untuk keamanan)
        abort_if($kelas->prodi_id !== Auth::user()->prodi->id, 403);

        $mahasiswaDiKelas = $kelas->mahasiswas()->pluck('mahasiswas.id');

        $mahasiswaTersedia = Mahasiswa::query()
            // ->where('prodi_id', Auth::user()->prodi->id) // Jika ada relasi mahasiswa ke prodi
            ->whereNotIn('id', $mahasiswaDiKelas)
            ->when($request->search, function ($query, $search) {
                $query->where('nama', 'like', "%{$search}%")->orWhere('nim', 'like', "%{$search}%");
            })
            ->get();
        
        return view('prodi.kelas.isikelas.show', compact('kelas', 'mahasiswaTersedia'));
    }

    // Logika untuk menambahkan mahasiswa ke kelas
    public function addMahasiswa(Request $request, Kelas $kelas)
    {
        $request->validate(['mahasiswa_id' => 'required|exists:mahasiswas,id']);

        $mahasiswaId = $request->mahasiswa_id;

        // 🎯 INI BAGIAN PENTINGNYA: LAKUKAN PEMERIKSAAN
        // Cek apakah mahasiswa ini sudah terdaftar di kelas manapun
        $kelasLain = DB::table('kelas_mahasiswa')
                        ->where('mahasiswa_id', $mahasiswaId)
                        ->join('kelas', 'kelas_mahasiswa.kelas_id', '=', 'kelas.id')
                        ->select('kelas.nama_kelas')
                        ->first();

        // Jika ditemukan ($kelasLain tidak null), maka gagalkan proses
        if ($kelasLain) {
            // Kembalikan ke halaman sebelumnya dengan pesan error
            return back()->withErrors([
                'mahasiswa_id' => 'Gagal! Mahasiswa ini sudah terdaftar di kelas lain (' . $kelasLain->nama_kelas . '). Harap keluarkan dari kelas tersebut terlebih dahulu.'
            ]);
        }

        // Jika lolos pemeriksaan, baru tambahkan mahasiswa ke kelas
        $kelas->mahasiswas()->attach($mahasiswaId);

        return back()->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    // Logika untuk mengeluarkan mahasiswa dari kelas
    public function removeMahasiswa(Request $request, Kelas $kelas)
    {
        $request->validate(['mahasiswa_id' => 'required|exists:mahasiswas,id']);
        $kelas->mahasiswas()->detach($request->mahasiswa_id);
        return back()->with('success', 'Mahasiswa berhasil dikeluarkan.');
    }
}
