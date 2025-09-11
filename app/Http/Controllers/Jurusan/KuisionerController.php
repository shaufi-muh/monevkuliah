<?php

namespace App\Http\Controllers\Jurusan;

use App\Http\Controllers\Controller;
use App\Models\Kuisioner;
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
        return view('jurusan.kuisioner.index', compact('kuisioners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jurusan.kuisioner.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
           // 'tahun_akademik' => 'required|string|max:9|regex:/^\d{4}\/\d{4}$/',
            'tahun_akademik' => [
                'required',
                'string',
                'max:9',
                'regex:/^\d{4}\/\d{4}$/'
            ],
            'semester' => 'required|in:Ganjil,Genap',
            'sesi' => 'required|in:Tengah,Akhir',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        Kuisioner::create($request->all() + ['jurusan_id' => Auth::user()->jurusan_id]);

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
        // 1. Validasi input
        $request->validate([
            'tahun_akademik' => 'required|string',
            'semester' => 'required|in:Ganjil,Genap',
            'sesi' => 'required|in:Tengah,Akhir',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        // 2. Update data pada model
        $kuisioner->update($request->all());

        // 3. Redirect ke halaman index dengan pesan sukses
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
