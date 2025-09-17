<?php

namespace App\Http\Controllers\Jurusan;

use App\Http\Controllers\Controller;
use App\Models\SemesterAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SemesterAkademikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jurusanId = Auth::user()->jurusan_id;
        $semesters = SemesterAkademik::where('jurusan_id', $jurusanId)
                                     ->orderBy('tahun_akademik', 'desc')
                                     ->orderBy('semester', 'desc')
                                     ->get();
        return view('jurusan.semesterakademik.index', compact('semesters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jurusan.semesterakademik.create');
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
                Rule::unique('semester_akademiks')->where(function ($query) use ($request, $jurusanId) {
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
            SemesterAkademik::where('jurusan_id', $jurusanId)
                          ->where('status', 'aktif')
                          ->update(['status' => 'tidak_aktif']);
        }

        SemesterAkademik::create($request->all() + ['jurusan_id' => $jurusanId]);

        return redirect()->route('jurusan.semester-akademik.index')
                         ->with('success', 'Semester Akademik berhasil ditambahkan.');
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
    public function edit(SemesterAkademik $semester_akademik)
{
    return view('jurusan.semesterakademik.edit', compact('semester_akademik'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SemesterAkademik $semester_akademik)
    {
        $jurusanId = Auth::user()->jurusan_id;

        $request->validate([
            'tahun_akademik' => [
                'required', 'string', 'max:20',
                Rule::unique('semester_akademiks')->where(function ($query) use ($request, $jurusanId) {
                    return $query->where('semester', $request->semester)
                                ->where('jurusan_id', $jurusanId);
                })->ignore($semester_akademik->id), // Abaikan data saat ini
            ],
            'semester' => 'required|in:Ganjil,Genap',
            'status' => 'required|in:aktif,tidak_aktif',
        ], [
            'tahun_akademik.unique' => 'Kombinasi Tahun Akademik dan Semester ini sudah ada.'
        ]);

        $semester_akademik->update($request->all());

        return redirect()->route('jurusan.semester-akademik.index')
                        ->with('success', 'Semester Akademik berhasil diperbarui.');
    }

    /* GEMINI
    $jurusanId = Auth::user()->jurusan_id;

    $request->validate([
        'tahun_akademik' => [
            'required', 'string', 'max:20',
            Rule::unique('semester_akademiks')->where(function ($query) use ($request, $jurusanId) {
                return $query->where('semester', $request->semester)
                             ->where('jurusan_id', $jurusanId);
            })->ignore($semester_akademik->id), // Abaikan data saat ini
        ],
        'semester' => 'required|in:Ganjil,Genap',
        'status' => 'required|in:aktif,tidak_aktif',
    ], [
        'tahun_akademik.unique' => 'Kombinasi Tahun Akademik dan Semester ini sudah ada.'
    ]);

    $semester_akademik->update($request->only(['tahun_akademik', 'semester']));

    return redirect()->route('jurusan.semester-akademik.index')
                     ->with('success', 'Semester Akademik berhasil diperbarui.');
                     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SemesterAkademik $semester_akademik)
    {
        // Keamanan
        if ($semester_akademik->jurusan_id != Auth::user()->jurusan_id) {
            abort(403);
        }

        // Peringatan: Tambahkan logika pengecekan jika semester sudah digunakan
        // di tabel mahasiswa_semesters sebelum menghapus.
        // if ($semester_akademik->mahasiswaSemesters()->exists()) {
        //     return back()->withErrors(['error' => 'Semester ini tidak bisa dihapus karena sudah memiliki data mahasiswa aktif.']);
        // }

        $semester_akademik->delete();

        return redirect()->route('jurusan.semester-akademik.index')
                        ->with('success', 'Semester Akademik berhasil dihapus.');
    }

    /**
     * Toggle the status of a SemesterAkademik between 'aktif' and 'tidak_aktif'.
     */

    public function toggleStatus(SemesterAkademik $semester_akademik)
    {
        $jurusanId = Auth::user()->jurusan_id;

        // Keamanan: Pastikan user hanya mengubah data miliknya
        if ($semester_akademik->jurusan_id != $jurusanId) {
            abort(403);
        }

        // Jika akan mengaktifkan (dari tidak aktif -> aktif)
        if ($semester_akademik->status == 'tidak_aktif') {
            // Nonaktifkan dulu semua semester lain yang mungkin aktif
            SemesterAkademik::where('jurusan_id', $jurusanId)
                        ->where('status', 'aktif')
                        ->update(['status' => 'tidak_aktif']);
        }

        // Lakukan toggle seperti biasa
        $semester_akademik->status = ($semester_akademik->status == 'aktif') ? 'tidak_aktif' : 'aktif';
        $semester_akademik->save();

        return redirect()->route('jurusan.semester-akademik.index')
                        ->with('success', 'Status Semester berhasil diperbarui.');
    }

    /*
    public function toggleStatus(SemesterAkademik $semester_akademik)
    {
        $jurusanId = Auth::user()->jurusan_id;

        // Keamanan: Pastikan user hanya mengubah data miliknya
        if ($semester_akademik->jurusan_id != $jurusanId) {
            abort(403);
        }

        // Jika akan mengaktifkan (dari tidak aktif -> aktif)
        if ($semester_akademik->status == 'tidak_aktif') {
            // Nonaktifkan dulu semua semester lain yang mungkin aktif
            SemesterAkademik::where('jurusan_id', $jurusanId)
                        ->where('status', 'aktif')
                        ->update(['status' => 'tidak_aktif']);
        }

        // Lakukan toggle seperti biasa
        $semester_akademik->status = ($semester_akademik->status == 'aktif') ? 'tidak_aktif' : 'aktif';
        $semester_akademik->save();

        return redirect()->route('jurusan.semester-akademik.index')
                        ->with('success', 'Status Semester berhasil diperbarui.');
    }
    */
}