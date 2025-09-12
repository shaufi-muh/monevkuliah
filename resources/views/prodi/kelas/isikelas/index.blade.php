<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Isi Kelas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-lg mb-4 border-b pb-3">Pilih Kelas untuk Dikelola</h3>
                    <p class="text-sm text-gray-600 mb-6">Silakan pilih salah satu kelas di bawah ini untuk menambahkan atau mengeluarkan mahasiswa.</p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @forelse ($kelasList as $kelas)
                            <a href="{{ route('prodi.isikelas.show', $kelas->id) }}" class="block p-4 bg-gray-100 rounded-lg border border-gray-200 hover:bg-indigo-100 hover:border-indigo-400 transition duration-150 ease-in-out">
                                <p class="font-bold text-lg text-gray-800">{{ $kelas->nama_kelas }}</p>
                                <p class="text-sm text-gray-500">{{ $kelas->mahasiswas->count() }} Mahasiswa</p>
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