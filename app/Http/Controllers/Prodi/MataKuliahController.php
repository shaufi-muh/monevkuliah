<?php

namespace App\Http\Controllers\Prodi;

use App\Http\Controllers\Controller;
use App\Models\MataKuliah; // <-- Import model
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mata_kuliahs = MataKuliah::latest()->paginate(10);
        return view('prodi.matakuliah.index', compact('mata_kuliahs'));
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
        // Validasi
        $request->validate([
            'kode_matkul' => 'required|string|max:10|unique:mata_kuliahs,kode_matkul',
            'nama_matkul' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:6',
            'urutan_semester' => 'required|integer|min:1|max:8',
        ]);

        // Simpan ke DB
        MataKuliah::create($request->all());

        return redirect()->route('prodi.matakuliah.index')
                         ->with('success', 'Mata kuliah berhasil ditambahkan.');
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
    public function edit(MataKuliah $matakuliah)
    {
        return view('prodi.matakuliah.edit', compact('matakuliah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MataKuliah $matakuliah)
    {
        $request->validate([
            'kode_matkul' => 'required|string|max:10|unique:mata_kuliahs,kode_matkul,' . $matakuliah->id,
            'nama_matkul' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:6',
            'urutan_semester' => 'required|integer|min:1|max:8',
        ]);

        $matakuliah->update($request->all());

        return redirect()->route('prodi.matakuliah.index')
                        ->with('success', 'Mata kuliah berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MataKuliah $matakuliah)
{
    $matakuliah->delete();

    return redirect()->route('prodi.matakuliah.index')
                     ->with('success', 'Mata kuliah berhasil dihapus.');
}
}
