<?php

namespace App\Http\Controllers\Jurusan;

use App\Http\Controllers\Controller;
use App\Models\Kuisioner;
use App\Models\TahunAkademik; // <-- Tambahkan use statement untuk model TahunAkademik
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KuisionerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jurusanId = Auth::user()->jurusan_id;
        $kuisioners = Kuisioner::where('jurusan_id', $jurusanId)->latest()->get();
        $tahunAkademikAktif = \App\Models\TahunAkademik::where('status', 'aktif')
            ->where('jurusan_id', $jurusanId)
            ->first();
        return view('jurusan.kuisioner.index', compact('kuisioners', 'tahunAkademikAktif'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunAkademikAktif = TahunAkademik::where('status', 'aktif')
                                            ->where('jurusan_id', Auth::user()->jurusan_id)
                                            ->first();

        return view('jurusan.kuisioner.create', compact('tahunAkademikAktif'));
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
                'max:9',
                'regex:/^\d{4}\/\d{4}$/',
                \Illuminate\Validation\Rule::unique('kuisioners')->where(function ($query) use ($request, $jurusanId) {
                    return $query->where('tahun_akademik', $request->tahun_akademik)
                                 ->where('semester', $request->semester)
                                 ->where('sesi', $request->sesi)
                                 ->where('jurusan_id', $jurusanId);
                }),
            ],
            'semester' => 'required|in:Ganjil,Genap',

            'sesi' => 'required|in:Tengah,Akhir',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,tidak_aktif',
        ], [
            'tahun_akademik.unique' => 'Set Kuisioner dengan kombinasi Tahun Akademik, Semester, dan Sesi sudah ada.'
        ]);
        // logika tambahan: pastikan ada tahun akademik aktif sebelum membuat kuisioner baru
        /*
        $tahunAkademikAktif = TahunAkademik::where('status', 'aktif')
            ->where('jurusan_id', Auth::user()->jurusan_id)
            ->first();

        if (!$tahunAkademikAktif) {
            return redirect()->back()->withInput()->withErrors(['tahun_akademik' => 'Tidak bisa membuat set kuisioner baru karena belum ada tahun akademik yang aktif. Silakan aktifkan tahun akademik terlebih dahulu.']);
        } 

        $request->merge([
            'tahun_akademik' => $tahunAkademikAktif->tahun_akademik,
            'semester' => $tahunAkademikAktif->semester,
            'tahun_akademik_id' => $tahunAkademikAktif->id
        ]);
        Kuisioner::create($request->all() + ['jurusan_id' => Auth::user()->jurusan_id]);

        Kuisioner::create($request->all() + ['jurusan_id' => $jurusanId]); 
        */

        Kuisioner::create($request->all() + ['jurusan_id' => $jurusanId]);

        return redirect()->route('jurusan.kuisioner.index')
                        ->with('success', 'Set Kuisioner berhasil dibuat.');
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
    public function edit(Kuisioner $kuisioner) // <-- Gunakan Route Model Binding
    {
        // Langsung kirim data kuisioner yang akan diedit ke view
        return view('jurusan.kuisioner.edit', compact('kuisioner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kuisioner $kuisioner) // <-- Gunakan Route Model Binding
    {
        $jurusanId = Auth::user()->jurusan_id;
        $request->validate([
            'tahun_akademik' => [
                'required',
                'string',
                'max:9',
                'regex:/^\d{4}\/\d{4}$/',
                \Illuminate\Validation\Rule::unique('kuisioners')->where(function ($query) use ($request, $jurusanId, $kuisioner) {
                    return $query->where('tahun_akademik', $request->tahun_akademik)
                                 ->where('semester', $request->semester)
                                 ->where('sesi', $request->sesi)
                                 ->where('jurusan_id', $jurusanId)
                                 ->where('id', '!=', $kuisioner->id);
                }),
            ],
            'semester' => 'required|in:Ganjil,Genap',
            'sesi' => 'required|in:Tengah,Akhir',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,tidak_aktif',
        ], [
            'tahun_akademik.unique' => 'Set Kuisioner dengan kombinasi Tahun Akademik, Semester, dan Sesi sudah ada.'
        ]);

        $kuisioner->update($request->all());

        return redirect()->route('jurusan.kuisioner.index')
                         ->with('success', 'Set Kuisioner berhasil diperbarui.');
    }

    /**
     * Mengubah status aktif/tidak_aktif dari sebuah kuisioner.
     */
    public function toggleStatus(Kuisioner $kuisioner)
    {
         // Pengecekan keamanan tambahan: pastikan user tidak mengubah data jurusan lain.
        if ($kuisioner->jurusan_id != Auth::user()->jurusan_id) {
            abort(403, 'AKSI TIDAK DIIZINKAN');
        }    
        
        // Aksi 1: Jika kita akan MENGAKTIFKAN kuisioner ini (dari tidak aktif -> aktif)
        if ($kuisioner->status == 'tidak_aktif') {
            // Maka, nonaktifkan dulu SEMUA kuisioner lain yang mungkin sedang aktif
            // untuk jurusan ini.
            Kuisioner::where('jurusan_id', $kuisioner->jurusan_id)
                    ->where('status', 'aktif')
                    ->update(['status' => 'tidak_aktif']);
        }
        
        // Aksi 2: Lakukan toggle seperti biasa pada kuisioner yang dipilih
        // Jika statusnya 'tidak_aktif' -> akan menjadi 'aktif'
        // Jika statusnya 'aktif' -> akan menjadi 'tidak_aktif'
        $kuisioner->status = ($kuisioner->status == 'aktif') ? 'tidak_aktif' : 'aktif';
        $kuisioner->save();

        $message = "Status kuisioner berhasil diperbarui.";

        return redirect()->route('jurusan.kuisioner.index')->with('success', $message);
        /*// 1. Balik nilainya: 
        //    Jika status saat ini 'aktif', ubah menjadi 'tidak_aktif'.
        //    Jika status saat ini 'tidak_aktif', ubah menjadi 'aktif'.
        $kuisioner->status = ($kuisioner->status == 'aktif') ? 'tidak_aktif' : 'aktif';

        // 2. Simpan perubahan ke database
        $kuisioner->save();                    ********* AKTIFKAN STATUS TANPA BATAS (BISA LEBIH DARI SATU SET KUISIONER *********)

        // 3. Siapkan pesan sukses berdasarkan status baru
        $message = "Status kuisioner berhasil diubah menjadi " . ($kuisioner->status == 'aktif' ? 'Aktif' : 'Tidak Aktif') . ".";

        // 4. Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('jurusan.kuisioner.index')->with('success', $message); */
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kuisioner $kuisioner) // <-- Gunakan Route Model Binding
{
    // Pengecekan keamanan
    if ($kuisioner->jurusan_id != Auth::user()->jurusan_id) {
        abort(403, 'AKSI TIDAK DIIZINKAN');
    }

    // Hapus data kuisioner (pertanyaan akan ikut terhapus otomatis)
    $kuisioner->delete();

    // Redirect kembali ke halaman index dengan pesan sukses
    return redirect()->route('jurusan.kuisioner.index')
                     ->with('success', 'Set Kuisioner berhasil dihapus.');
}
}
