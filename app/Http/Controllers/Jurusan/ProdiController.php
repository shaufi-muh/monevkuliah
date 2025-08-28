<?php

namespace App\Http\Controllers\Jurusan;

use App\Http\Controllers\Controller;
use App\Models\User; // <-- Gunakan model User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // <-- Untuk enkripsi password

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Menampilkan daftar semua user prodi
    public function index()
    {
        // Ambil semua user yang rolenya 'prodi'
        $prodis = User::where('role', 'prodi')->get();
        return view('jurusan.prodi.index', compact('prodis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // Menampilkan form untuk menambah prodi baru
    public function create()
    {
        return view('jurusan.prodi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    // Menyimpan data prodi baru ke database
    public function store(Request $request)
    {
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

        return redirect()->route('prodi.index')->with('success', 'User Prodi berhasil ditambahkan.');
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
