<?php

namespace App\Http\Controllers\Jurusan;

use App\Http\Controllers\Controller;
use App\Models\User; // <-- Gunakan model User
use App\Models\Prodi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // <-- Untuk enkripsi password

class UserProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Menampilkan daftar semua user prodi
    public function index()
    {
        // Ambil semua data user untuk ditampilkan di tabel
        $users = User::with('jurusan')->latest()->paginate(5); // Paginate 10 data per halaman
        
        // Ambil semua data prodi untuk ditampilkan di dropdown form
        $prodis = Prodi::orderBy('nama_prodi', 'asc')->get();
        
        // Dapatkan ID jurusan dari user yang sedang login
        // Asumsi user jurusan punya relasi atau kolom 'jurusan_id'
        $jurusanId = Auth::user()->jurusan_id; 

        // Ambil semua user yang role-nya 'prodi' DAN
        // prodinya memiliki jurusan_id yang sama dengan user yang login.
        $users = User::where('role', 'prodi')
                          ->whereHas('prodi', function ($query) use ($jurusanId) {
                              $query->where('jurusan_id', $jurusanId);
                          })->with('prodi')->paginate(5);

        // Kirim data ke view
        return view('jurusan.userprodi.index', compact('users', 'prodis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // Menampilkan form untuk menambah user prodi baru
    public function create()
    {
        //return view('jurusan.prodi.create'); batal
        // Ambil daftar prodi yang ada di bawah jurusan ini saja
        $jurusanId = Auth::user()->jurusan_id;
        $prodiList = Prodi::where('jurusan_id', $jurusanId)->get();

        return view('jurusan.userprodi.create', compact('prodiList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // Menyimpan data prodi baru ke database
    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'prodi_id' => 'required|exists:prodis,id',
        ]);

        // 2. Simpan data user baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Jangan lupa hash password
            'role' => 'prodi', // Hardcode role sebagai 'prodi'
            'prodi_id' => $request->prodi_id,
            'jurusan_id' => auth()->user()->jurusan_id,
        ]);
        
        // 3. Redirect ke halaman index dengan pesan sukses
        return redirect()->route('jurusan.userprodi.index')->with('success', 'User Prodi berhasil ditambahkan.');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
 /* BATAAAALLLLL
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Buat user baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'prodi', // <-- Set role secara otomatis
        ]);

        return redirect()->route('prodi.index')->with('success', 'User Prodi berhasil ditambahkan.'); */