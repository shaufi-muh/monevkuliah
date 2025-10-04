<?php

namespace App\Http\Controllers\Prodi;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
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

        $tab = $request->get('tab', 'mahasiswa');

        // Mahasiswa
        $mahasiswaDiKelas = $kelas->mahasiswas()->pluck('mahasiswas.id');
        $prodi_id = Auth::user()->prodi_id ?? (Auth::user()->prodi->id ?? null);
        $mahasiswaTersedia = Mahasiswa::query()
            ->where('prodi_id', $prodi_id)
            ->whereNotIn('id', $mahasiswaDiKelas)
            ->when($request->search, function ($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                      ->orWhere('nim', 'like', "%{$search}%");
                });
            })
            ->get();

        // Mata Kuliah
        $matkulDiKelas = $kelas->mataKuliahs()->pluck('mata_kuliahs.id');
        $matkulQuery = MataKuliah::whereNotIn('id', $matkulDiKelas)
            ->where('urutan_semester', $kelas->urutan_semester);
        if ($tab === 'matkul' && $request->filled('search_matkul')) {
            $search = $request->input('search_matkul');
            $matkulQuery->where(function($q) use ($search) {
                $q->where('nama_matkul', 'like', "%$search%")
                  ->orWhere('kode_matkul', 'like', "%$search%") ;
            });
        }
        $matkulTersedia = $matkulQuery->get();

        return view('prodi.kelas.isikelas.show', compact('kelas', 'mahasiswaTersedia', 'matkulTersedia', 'tab'));
    }
    // Tambah mata kuliah ke kelas
    public function addMataKuliah(Request $request, Kelas $kelas)
    {
        $request->validate(['mata_kuliah_id' => 'required|exists:mata_kuliahs,id']);
        $kelas->mataKuliahs()->syncWithoutDetaching([$request->mata_kuliah_id]);
        return back()->with('success', 'Mata kuliah berhasil ditambahkan.')->with('tab', 'matkul');
    }

    // Hapus mata kuliah dari kelas
    public function removeMataKuliah(Request $request, Kelas $kelas)
    {
        $request->validate(['mata_kuliah_id' => 'required|exists:mata_kuliahs,id']);
        $kelas->mataKuliahs()->detach($request->mata_kuliah_id);
        return back()->with('success', 'Mata kuliah berhasil dihapus.')->with('tab', 'matkul');
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
