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
        $mata_kuliahs = MataKuliah::with('dosenPengampu')->latest()->paginate(10);
        $dosens = \App\Models\Dosen::orderBy('nama_dosen')->get();
        return view('prodi.matakuliah.index', compact('mata_kuliahs', 'dosens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dosens = \App\Models\Dosen::orderBy('nama_dosen')->get();
        return view('prodi.matakuliah.create', compact('dosens'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_matkul' => 'required|string|max:10|unique:mata_kuliahs,kode_matkul',
            'nama_matkul' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:6',
            'urutan_semester' => 'required|integer|min:1|max:8',
            'dosen_pengampu' => 'required|array',
            'dosen_pengampu.*' => 'exists:dosens,id',
        ]);

        $matkul = MataKuliah::create($request->only(['kode_matkul','nama_matkul','sks','urutan_semester']));
        $tahunAkademikAktif = \App\Models\TahunAkademik::where('status', 'aktif')->first();
        $pivotData = [];
        foreach ($request->dosen_pengampu as $dosenId) {
            $pivotData[$dosenId] = ['tahun_akademik_id' => $tahunAkademikAktif ? $tahunAkademikAktif->id : null];
        }
        $matkul->dosenPengampu()->attach($pivotData);

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
        $dosens = \App\Models\Dosen::orderBy('nama_dosen')->get();
        $selectedDosen = $matakuliah->dosenPengampu->pluck('id')->toArray();
        return view('prodi.matakuliah.edit', compact('matakuliah','dosens','selectedDosen'));
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
            'dosen_pengampu' => 'required|array',
            'dosen_pengampu.*' => 'exists:dosens,id',
        ]);

        $matakuliah->update($request->only(['kode_matkul','nama_matkul','sks','urutan_semester']));
        $tahunAkademikAktif = \App\Models\TahunAkademik::where('status', 'aktif')->first();
        $pivotData = [];
        foreach ($request->dosen_pengampu as $dosenId) {
            $pivotData[$dosenId] = ['tahun_akademik_id' => $tahunAkademikAktif ? $tahunAkademikAktif->id : null];
        }
        $matakuliah->dosenPengampu()->sync($pivotData);

        return redirect()->route('prodi.matakuliah.index')
                        ->with('success', 'Mata kuliah berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MataKuliah $matakuliah)
    {
        $matakuliah->dosenPengampu()->detach();
        $matakuliah->delete();
        return redirect()->route('prodi.matakuliah.index')
                         ->with('success', 'Mata kuliah berhasil dihapus.');
    }
}
