<?php

namespace App\Http\Controllers\Prodi;

use App\Http\Controllers\Controller;

use App\Models\Dosen; // <-- Import model Dosen
use App\Models\Prodi; // <-- Import model Prodi

use Illuminate\Http\Request;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Ambil semua data prodi untuk ditampilkan di dropdown form
        $prodis = Prodi::orderBy('nama_prodi', 'asc')->get();

        // Ambil semua data dosen untuk ditampilkan di tabel
        $dosens = Dosen::with('prodi')->latest()->paginate(10); // Paginate 10 data per halaman

        // Kirim data prodi dan dosen ke view
        return view('prodi.dosen.index', compact('prodis', 'dosens'));

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
            'nama_dosen' => 'required|string|max:255',
            'nip' => 'nullable|string|max:18|unique:dosens,nip',
            'nuptk' => 'nullable|string|max:16|unique:dosens,nip',
            'prodi_id' => 'required|exists:prodis,id',
        ]);

        // 2. Simpan data ke database
        Dosen::create([
            'nama_dosen' => $request->nama_dosen,
            'nip' => $request->nip,
            'nuptk' => $request->nuptk,
            'prodi_id' => $request->prodi_id,
        ]);

        // 3. Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('prodi.dosen.index')
                         ->with('success', 'Data dosen berhasil ditambahkan.');

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
    public function edit(Dosen $dosen)
    {
        // Ambil semua data prodi untuk dropdown
        $prodis = Prodi::orderBy('nama_prodi', 'asc')->get();
        
        // Tampilkan view edit dan kirim data dosen yang akan diedit serta data prodi
        return view('prodi.dosen.edit', compact('dosen', 'prodis'));
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * Memperbarui data dosen di database.
     */
    public function update(Request $request, Dosen $dosen)
    {
        // 1. Validasi Input
        $request->validate([
            'nama_dosen' => 'required|string|max:255',
            // Aturan unique diupdate agar mengabaikan data dosen saat ini
            'nip' => 'nullable|string|max:18|unique:dosens,nip,' . $dosen->id,
            'nuptk' => 'nullable|string|max:16|unique:dosens,nuptk,' . $dosen->id,
            'prodi_id' => 'required|exists:prodis,id',
        ]);

        // 2. Update data di database
        $dosen->update([
            'nama_dosen' => $request->nama_dosen,
            'nip' => $request->nip,
            'nuptk' => $request->nuptk,
            'prodi_id' => $request->prodi_id,
        ]);

        // 3. Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('prodi.dosen.index')
                        ->with('success', 'Data dosen berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * Menghapus data dosen dari database.
     */
    public function destroy(Dosen $dosen)
    {
        // Hapus data
        $dosen->delete();

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('prodi.dosen.index')
                        ->with('success', 'Data dosen berhasil dihapus.');
    }
}
