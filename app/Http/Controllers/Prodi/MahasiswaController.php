<?php

namespace App\Http\Controllers\Prodi;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa; // <-- Import model
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswas = Mahasiswa::latest()->paginate(10);
        return view('prodi.mahasiswa.index', compact('mahasiswas'));
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
            'nim' => 'required|string|max:10|unique:mahasiswas,nim',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:mahasiswas,email',
            'no_telp' => 'nullable|string|max:15',
            'status_mahasiswa' => 'required|in:Aktif,Cuti,Non-Aktif',
        ]);

        // Ambil prodi_id dari user yang sedang login
        $user = auth()->user();
        $prodi_id = $user->prodi_id ?? null;
        if (!$prodi_id) {
            // Jika tidak ada prodi_id, bisa dilempar error atau handle lain
            return redirect()->back()->withErrors(['prodi_id' => 'Prodi tidak ditemukan pada user.']);
        }

        $mahasiswaData = $request->except('status_mahasiswa');
        $mahasiswaData['prodi_id'] = $prodi_id;
        $mahasiswa = Mahasiswa::create($mahasiswaData);

        // Ambil tahun akademik aktif
        $tahunAkademikAktif = \App\Models\TahunAkademik::where('status', 'aktif')->first();
        if ($tahunAkademikAktif) {
            \App\Models\MahasiswaSemester::create([
                'mahasiswa_id' => $mahasiswa->id,
                'tahun_akademik_id' => $tahunAkademikAktif->id,
                'status_mahasiswa' => $request->input('status_mahasiswa', 'Aktif'),
            ]);
        }

        return redirect()->route('prodi.mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil ditambahkan.');
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
    public function edit(Mahasiswa $mahasiswa)
    {
        // Ambil tahun akademik aktif
        $tahunAkademikAktif = \App\Models\TahunAkademik::where('status', 'aktif')->first();
        $pivot = null;
        if ($tahunAkademikAktif) {
            $pivot = $mahasiswa->mahasiswaSemesters->where('tahun_akademik_id', $tahunAkademikAktif->id)->first();
        }
        return view('prodi.mahasiswa.edit', compact('mahasiswa', 'pivot'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'nim' => 'required|string|max:10|unique:mahasiswas,nim,' . $mahasiswa->id,
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:mahasiswas,email,' . $mahasiswa->id,
            'no_telp' => 'nullable|string|max:15',
            'status_mahasiswa' => 'required|in:Aktif,Cuti,Non-Aktif',
        ]);

        $mahasiswa->update($request->except('status_mahasiswa'));

        // Update status_mahasiswa di pivot tahun akademik aktif
        $tahunAkademikAktif = \App\Models\TahunAkademik::where('status', 'aktif')->first();
        if ($tahunAkademikAktif) {
            $pivot = \App\Models\MahasiswaSemester::where('mahasiswa_id', $mahasiswa->id)
                ->where('tahun_akademik_id', $tahunAkademikAktif->id)
                ->first();
            if ($pivot) {
                $pivot->status_mahasiswa = $request->input('status_mahasiswa');
                $pivot->save();
            } else {
                \App\Models\MahasiswaSemester::create([
                    'mahasiswa_id' => $mahasiswa->id,
                    'tahun_akademik_id' => $tahunAkademikAktif->id,
                    'status_mahasiswa' => $request->input('status_mahasiswa'),
                ]);
            }
        }

        return redirect()->route('prodi.mahasiswa.index')
                         ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();

        return redirect()->route('prodi.mahasiswa.index')
                         ->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}
