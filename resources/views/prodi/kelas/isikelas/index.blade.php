<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Isi Kelas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-lg mb-4 border-b pb-3">Pilih Kelas untuk Dikelola</h3>
                    <p class="text-sm text-gray-600 mb-6">Silakan pilih salah satu kelas di bawah ini untuk menambahkan atau mengeluarkan mahasiswa serta menambahkan atau menghapus mata kuliah.</p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @forelse ($kelasList as $kelas)
                            <a href="{{ route('prodi.isikelas.show', $kelas->id) }}" class="block p-4 bg-gray-100 rounded-lg border border-gray-200 hover:bg-indigo-100 hover:border-indigo-400 transition duration-150 ease-in-out">
                                <p class="font-bold text-lg text-gray-800 mb-2">{{ $kelas->nama_kelas }}</p>
                                <div class="flex items-center gap-4 text-sm text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 0 0-3-3.87M9 20H4v-2a4 4 0 0 1 3-3.87m6 5.87v-2a4 4 0 0 0-3-3.87m0 0a4 4 0 1 1 6 0m-6 0V7a4 4 0 1 1 8 0v5"></path></svg>
                                        {{ $kelas->mahasiswas->count() }} Mahasiswa
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/></svg>
                                        {{ $kelas->mataKuliahs->count() }} Mata Kuliah
                                    </span>
                                </div>
                            </a>
                        @empty
                            <div class="col-span-full text-center py-10 px-6 bg-gray-50 rounded-lg">
                                <p class="text-gray-500">
                                    Belum ada data kelas yang dibuat. Silakan buat data kelas terlebih dahulu di menu "Data Kelas".
                                </p>
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>