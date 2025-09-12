<?php

namespace App\Http\Controllers\Prodi;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Prodi; // Jangan lupa import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data prodi yang sedang login
        $prodi = Auth::user()->prodi; // Asumsi user prodi punya relasi ke prodi

        // Ambil kelas yang hanya milik prodi tersebut
        $kelasList = Kelas::where('prodi_id', $prodi->id)->latest()->get();

        return view('prodi.kelas.datakelas.index', compact('prodi', 'kelasList'))
        ->with('success', 'Data Kelas berhasil ditambahkan.');
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
        $request->validate([
            'urutan_semester' => 'required|integer|min:1|max:14',
            'grup_kelas' => 'required|string|max:1|alpha',
        ]);

        $prodi = Auth::user()->prodi;

        // Buat nama_kelas secara otomatis
        $nama_kelas = strtoupper($prodi->akronim_prodi . '-' . $request->urutan_semester . $request->grup_kelas);

        // Cek jika nama kelas sudah ada
        if (Kelas::where('nama_kelas', $nama_kelas)->exists()) {
            return back()->withErrors(['nama_kelas' => 'Nama kelas ini sudah ada.'])->withInput();
        }

        Kelas::create([
            'prodi_id' => $prodi->id,
            'urutan_semester' => $request->urutan_semester,
            'grup_kelas' => strtoupper($request->grup_kelas),
            'nama_kelas' => $nama_kelas,
        ]);

        return redirect()->route('prodi.datakelas.index')->with('success', 'Data kelas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Menampilkan form untuk mengedit data kelas.
     */
    //public function edit(Kelas $datakela) // Laravel secara otomatis mengubah 'kelas' menjadi 'kela' untuk menghindari konflik
    public function edit(Kelas $kela)
    {
        // Kita ganti nama variabelnya agar lebih intuitif
        //$kelas = $datakela;
        $kelas = $kela;
        return view('prodi.kelas.datakelas.edit', compact('kelas'));
    }

    /**
     * Memperbarui data kelas di database.
     */
    //public function update(Request $request, Kelas $datakela)
    public function update(Request $request, Kelas $kela)
    {
        //$kelas = $datakela;
        $kelas = $kela;
        $request->validate([
            'urutan_semester' => 'required|integer|min:1|max:14',
            'grup_kelas' => 'required|string|max:1|alpha',
        ]);

        $prodi = Auth::user()->prodi;

        // Buat nama_kelas baru berdasarkan input
        $nama_kelas_baru = strtoupper($prodi->akronim_prodi . '-' . $request->urutan_semester . $request->grup_kelas);

        // Cek jika nama kelas baru sudah ada di record lain (selain record yg sedang diedit)
        if (Kelas::where('nama_kelas', $nama_kelas_baru)->where('id', '!=', $kelas->id)->exists()) {
            return back()->withErrors(['nama_kelas' => 'Nama kelas ini sudah ada.'])->withInput();
        }

        // Update data di database
        $kelas->update([
            'urutan_semester' => $request->urutan_semester,
            'grup_kelas' => strtoupper($request->grup_kelas),
            'nama_kelas' => $nama_kelas_baru,
        ]);

        return redirect()->route('prodi.datakelas.index')
                        ->with('success', 'Data kelas berhasil diperbarui.');
    }

    /**
     * Menghapus data kelas dari database.
     */
    //public function destroy(Kelas $datakela)
    public function destroy(Kelas $kela)
    {
        //$kelas = $datakela;
        $kelas = $kela;
        
        // Karena kita sudah set 'onDelete('cascade')' di migration 'kelas_mahasiswa',
        // semua mahasiswa yang ada di kelas ini akan otomatis dikeluarkan (relasinya dihapus)
        // sebelum kelasnya itu sendiri dihapus.
        $kelas->delete();

        return redirect()->route('prodi.datakelas.index')
                        ->with('success', 'Data kelas berhasil dihapus.');
    }
}
