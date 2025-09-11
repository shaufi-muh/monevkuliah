<?php

namespace App\Http\Controllers\Jurusan;

use App\Http\Controllers\Controller;
use App\Models\Pertanyaan;
use App\Models\Kuisioner; // <-- Import model Kuisioner
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PertanyaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) // <-- Tambahkan Request $request
    {
        /*$jurusanId = Auth::user()->jurusan_id;

        // Ambil semua set kuisioner milik jurusan ini,
        // beserta semua pertanyaan di dalamnya (Eager Loading)  ****** SEBELUM FILTER MENAMPILKAN PER MAP KUISIONER ******
        $kuisioners = Kuisioner::where('jurusan_id', $jurusanId)
                                ->with('pertanyaans') // Ambil relasi pertanyaans
                                ->latest()->get();

        return view('jurusan.pertanyaan.index', compact('kuisioners')); */
        $jurusanId = Auth::user()->jurusan_id;

        // 1. Ambil SEMUA set kuisioner milik jurusan ini untuk pilihan di dropdown.
        $kuisionerOptions = Kuisioner::where('jurusan_id', $jurusanId)->latest()->get();

        // 2. Siapkan variabel untuk menampung data yang akan ditampilkan.
        $selectedKuisioner = null;
        $pertanyaans = collect(); // Gunakan collection kosong sebagai default
        $selectedId = $request->input('kuisioner_id');

        // 3. HANYA JIKA ada ID yang dipilih dari dropdown, cari datanya.
        if ($selectedId) {
            // Cari kuisioner yang dipilih
            $selectedKuisioner = $kuisionerOptions->find($selectedId);

            // Jika kuisioner ditemukan, ambil pertanyaannya secara eksplisit
            if ($selectedKuisioner) {
                $pertanyaans = Pertanyaan::where('kuisioner_id', $selectedKuisioner->id)
                                        ->orderBy('urutan', 'asc')
                                        ->get();
            }
        }

        // 4. Kirim data yang sudah bersih ke view.
        return view('jurusan.pertanyaan.index', [
            'kuisionerOptions' => $kuisionerOptions,
            'selectedKuisioner' => $selectedKuisioner,
            'pertanyaans' => $pertanyaans, // Kirim variabel pertanyaan yang sudah terfilter
            'selectedId' => $selectedId,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jurusanId = Auth::user()->jurusan_id;
        
        // Ambil daftar kuisioner untuk ditampilkan di dropdown
        $kuisioners = Kuisioner::where('jurusan_id', $jurusanId)->get();

        return view('jurusan.pertanyaan.create', compact('kuisioners'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kuisioner_id' => 'required|exists:kuisioners,id', // Validasi wadahnya
            'isi_pertanyaan' => 'required|string',
            'tipe_jawaban' => 'required|in:numerik,boolean',
            'urutan' => 'required|integer',
        ]);

        Pertanyaan::create($request->all());

        return redirect()->route('jurusan.pertanyaan.index')
                         ->with('success', 'Pertanyaan baru berhasil ditambahkan.');
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
    public function edit(Pertanyaan $pertanyaan) // <-- Gunakan Route Model Binding
    {
        $jurusanId = Auth::user()->jurusan_id;

        // Ambil daftar kuisioner untuk pilihan dropdown
        $kuisioners = Kuisioner::where('jurusan_id', $jurusanId)->get();

        // Kirim data pertanyaan yang akan diedit dan daftar kuisioner ke view
        return view('jurusan.pertanyaan.edit', compact('pertanyaan', 'kuisioners'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pertanyaan $pertanyaan) // <-- Gunakan Route Model Binding
    {
        // 1. Validasi input
        $request->validate([
            'kuisioner_id'   => 'required|exists:kuisioners,id',
            'isi_pertanyaan' => 'required|string',
            'tipe_jawaban'   => 'required|in:numerik,boolean',
            'urutan'         => 'required|integer',
        ]);

        // 2. Update data pertanyaan
        $pertanyaan->update($request->all());

        // 3. Redirect kembali ke halaman index dengan filter aktif
        return redirect()->route('jurusan.pertanyaan.index', ['kuisioner_id' => $request->kuisioner_id])
                        ->with('success', 'Pertanyaan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pertanyaan $pertanyaan) // <-- Gunakan Route Model Binding
{
    // 1. Simpan dulu ID kuisioner-nya untuk redirect
    $kuisionerId = $pertanyaan->kuisioner_id;

    // 2. Hapus data pertanyaan
    $pertanyaan->delete();

    // 3. Redirect kembali ke halaman index DENGAN FILTER YANG SAMA
    return redirect()->route('jurusan.pertanyaan.index', ['kuisioner_id' => $kuisionerId])
                     ->with('success', 'Pertanyaan berhasil dihapus.');
}
}
