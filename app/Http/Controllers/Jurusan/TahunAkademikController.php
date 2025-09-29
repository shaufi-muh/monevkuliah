<?php

namespace App\Http\Controllers\Jurusan;

use App\Http\Controllers\Controller;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TahunAkademikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jurusanId = Auth::user()->jurusan_id;
        $tahunAkademiks = TahunAkademik::where('jurusan_id', $jurusanId)
            ->orderBy('tahun_akademik', 'desc')
            ->orderBy('semester', 'desc')
            ->get();
        return view('jurusan.tahunakademik.index', compact('tahunAkademiks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jurusan.tahunakademik.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $jurusanId = Auth::user()->jurusan_id;

        $request->validate([
            'tahun_akademik' => [
                'required',
                'string',
                'max:20',
                'regex:/^\d{4}\/\d{4}$/',
                Rule::unique('tahun_akademiks')->where(function ($query) use ($request, $jurusanId) {
                    return $query->where('semester', $request->semester)
                                 ->where('jurusan_id', $jurusanId);
                }),
            ],
            'semester' => 'required|in:Ganjil,Genap',
            'status' => 'required|in:aktif,tidak_aktif',
        ], [
            'tahun_akademik.unique' => 'Kombinasi Tahun Akademik dan Semester ini sudah ada.'
        ]);

        // Aturan "Singleton Active": Jika statusnya 'aktif', nonaktifkan yang lain dulu.
        if ($request->status == 'aktif') {
            TahunAkademik::where('jurusan_id', $jurusanId)
                          ->where('status', 'aktif')
                          ->update(['status' => 'tidak_aktif']);
        }

        TahunAkademik::create($request->all() + ['jurusan_id' => $jurusanId]);

        return redirect()->route('jurusan.tahun-akademik.index')
                         ->with('success', 'Data Tahun Akademik berhasil ditambahkan.');
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
    public function edit(TahunAkademik $tahun_akademik)
{
    return view('jurusan.tahunakademik.edit', compact('tahun_akademik'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TahunAkademik $tahun_akademik)
    {
        $jurusanId = Auth::user()->jurusan_id;

        $request->validate([
            'tahun_akademik' => [
                'required', 'string', 'max:20',
                Rule::unique('tahun_akademiks')->where(function ($query) use ($request, $jurusanId) {
                    return $query->where('semester', $request->semester)
                                ->where('jurusan_id', $jurusanId);
                })->ignore($tahun_akademik->id), // Abaikan data saat ini
            ],
            'semester' => 'required|in:Ganjil,Genap',
            'status' => 'required|in:aktif,tidak_aktif',
        ], [
            'tahun_akademik.unique' => 'Kombinasi Tahun Akademik dan Tahun ini sudah ada.'
        ]);

        $tahun_akademik->update($request->all());

        return redirect()->route('jurusan.tahun-akademik.index')
                        ->with('success', 'Data Tahun Akademik berhasil diperbarui.');
    }

    /* GEMINI
    $jurusanId = Auth::user()->jurusan_id;

    $request->validate([
        'tahun_akademik' => [
            'required', 'string', 'max:20',
            Rule::unique('tahun_akademiks')->where(function ($query) use ($request, $jurusanId) {
                return $query->where('semester', $request->semester)
                             ->where('jurusan_id', $jurusanId);
            })->ignore($tahun_akademik->id), // Abaikan data saat ini
        ],
        'semester' => 'required|in:Ganjil,Genap',
        'status' => 'required|in:aktif,tidak_aktif',
    ], [
        'tahun_akademik.unique' => 'Kombinasi Tahun Akademik dan Semester ini sudah ada.'
    ]);

    $tahun_akademik->update($request->only(['tahun_akademik', 'semester']));

    return redirect()->route('jurusan.tahun-akademik.index')
                     ->with('success', 'Tahun Akademik berhasil diperbarui.');
                     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TahunAkademik $tahun_akademik)
    {
        // Keamanan
        if ($tahun_akademik->jurusan_id != Auth::user()->jurusan_id) {
            abort(403);
        }

        // Peringatan: Tambahkan logika pengecekan jika tahun sudah digunakan
        // di tabel mahasiswa_tahuns sebelum menghapus.
        // if ($tahun_akademik->mahasiswaTahuns()->exists()) {
        //     return back()->withErrors(['error' => 'Tahun ini tidak bisa dihapus karena sudah memiliki data mahasiswa aktif.']);
        // }

        $tahun_akademik->delete();

        return redirect()->route('jurusan.tahun-akademik.index')
                        ->with('success', 'Data Tahun Akademik berhasil dihapus.');
    }

    /**
     * Toggle the status of a TahunAkademik between 'aktif' and 'tidak_aktif'.
     */

    public function toggleStatus(TahunAkademik $tahun_akademik)
    {
        $jurusanId = Auth::user()->jurusan_id;

        // Keamanan: Pastikan user hanya mengubah data miliknya
        if ($tahun_akademik->jurusan_id != $jurusanId) {
            abort(403);
        }

        // Jika akan mengaktifkan (dari tidak aktif -> aktif)
        if ($tahun_akademik->status == 'tidak_aktif') {
            // Nonaktifkan dulu semua tahun lain yang mungkin aktif
            TahunAkademik::where('jurusan_id', $jurusanId)
                        ->where('status', 'aktif')
                        ->update(['status' => 'tidak_aktif']);
        }

        // Lakukan toggle seperti biasa
        $tahun_akademik->status = ($tahun_akademik->status == 'aktif') ? 'tidak_aktif' : 'aktif';
        $tahun_akademik->save();

        return redirect()->route('jurusan.tahun-akademik.index')
                        ->with('success', 'Data Tahun Akademik berhasil diperbarui.');
    }

    /*
    public function toggleStatus(TahunAkademik $tahun_akademik)
    {
        $jurusanId = Auth::user()->jurusan_id;

        // Keamanan: Pastikan user hanya mengubah data miliknya
        if ($tahun_akademik->jurusan_id != $jurusanId) {
            abort(403);
        }

        // Jika akan mengaktifkan (dari tidak aktif -> aktif)
        if ($tahun_akademik->status == 'tidak_aktif') {
            // Nonaktifkan dulu semua tahun lain yang mungkin aktif
            TahunAkademik::where('jurusan_id', $jurusanId)
                        ->where('status', 'aktif')
                        ->update(['status' => 'tidak_aktif']);
        }

        // Lakukan toggle seperti biasa
        $tahun_akademik->status = ($tahun_akademik->status == 'aktif') ? 'tidak_aktif' : 'aktif';
        $tahun_akademik->save();

        return redirect()->route('jurusan.tahun-akademik.index')
                        ->with('success', 'Status Tahun berhasil diperbarui.');
    }
    */
}