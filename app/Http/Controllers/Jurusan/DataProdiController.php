<?php

namespace App\Http\Controllers\Jurusan;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use Illuminate\Http\Request;

class DataProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data prodi untuk ditampilkan di tabel
        $prodis = Prodi::with('jurusan')->latest()->paginate(5); // Paginate 10 data per halaman

        // Kirim data prodi ke view
        return view('jurusan.dataprodi.index', compact('prodis'));
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
        // 1. Validasi Input
        $request->validate([
            'nama_prodi' => 'required|string|max:255',
            'kode_prodi' => 'required|string|max:18',
            'akronim_prodi' => 'required|string|max:18',
        ]);

        // 2. Simpan data ke database
        Prodi::create([
            'nama_prodi' => $request->nama_prodi,
            'kode_prodi' => $request->kode_prodi,
            'akronim_prodi' => $request->akronim_prodi,
            'jurusan_id' => auth()->user()->jurusan_id,
        ]);

        // 3. Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('jurusan.dataprodi.index')
                         ->with('success', 'Data prodi berhasil ditambahkan.');
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
    public function edit(Prodi $dataprodi)
    {
        // Ambil semua data prodi untuk dropdown
        $prodis = Prodi::orderBy('nama_prodi', 'asc')->get();

        return view('jurusan.dataprodi.edit', compact('dataprodi','prodis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prodi $dataprodi)
    {
        $request->validate([
            'nama_prodi' => 'required|string|max:255',
            'kode_prodi' => 'required|string|max:18',
            'akronim_prodi' => 'required|string|max:18',
        ]);
        /*$dataprodi->update($request->all()); */
        // 2. Update data di database
        $dataprodi->update([
            'nama_prodi' => $request->nama_prodi,
            'kode_prodi' => $request->kode_prodi,
            'akronim_prodi' => $request->akronim_prodi,
            'jurusan_id' => auth()->user()->jurusan_id,
        ]);
        return redirect()->route('jurusan.dataprodi.index')
                        ->with('success', 'Data Prodi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prodi $dataprodi)
    {
        // Hapus data
        $dataprodi->delete();

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('jurusan.dataprodi.index')
                        ->with('success', 'Data Prodi berhasil dihapus.');
    }
}
