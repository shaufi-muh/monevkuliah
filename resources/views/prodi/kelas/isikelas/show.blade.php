<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mengelola Isi Kelas: <span class="font-bold">{{ $kelas->nama_kelas }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-4">
                <a href="{{ route('prodi.isikelas.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                    &larr; Kembali ke Pilihan Kelas
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <div class="border rounded-lg p-4">
                        <h3 class="font-semibold text-lg mb-4">Mahasiswa di Kelas Ini ({{ $kelas->mahasiswas->count() }})</h3>
                        <ul class="divide-y divide-gray-200 max-h-96 overflow-y-auto">
                            @forelse ($kelas->mahasiswas as $mhs)
                                <li class="py-3 flex items-center justify-between">
                                    <div>
                                        <p class="font-medium">{{ $mhs->nama }}</p>
                                        <p class="text-sm text-gray-500">{{ $mhs->nim }}</p>
                                    </div>
                                    <form action="{{ route('prodi.isikelas.remove', $kelas->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="mahasiswa_id" value="{{ $mhs->id }}">
                                        <button type="submit" class="px-2 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded hover:bg-red-200">
                                            Keluarkan
                                        </button>
                                    </form>
                                </li>
                            @empty
                                <li class="py-3 text-center text-gray-500">Belum ada mahasiswa di kelas ini.</li>
                            @endforelse
                        </ul>
                    </div>

                    <div class="border rounded-lg p-4">
                        <h3 class="font-semibold text-lg mb-4">Mahasiswa yang Tersedia</h3>
                        <form method="GET" action="{{ route('prodi.isikelas.show', $kelas->id) }}" class="mb-4">
                            <div class="flex">
                                <input type="text" name="search" placeholder="Cari Nama atau NIM..." class="flex-grow rounded-l-md border-gray-300 shadow-sm" value="{{ request('search') }}">
                                <button type="submit" class="px-4 py-2 bg-gray-800 border rounded-r-md font-semibold text-xs text-white uppercase hover:bg-gray-700">
                                    Cari
                                </button>
                            </div>
                        </form>
                        
                        <ul class="divide-y divide-gray-200 max-h-96 overflow-y-auto">
                            @forelse ($mahasiswaTersedia as $mhs)
                                <li class="py-3 flex items-center justify-between">
                                    <div>
                                        <p class="font-medium">{{ $mhs->nama }}</p>
                                        <p class="text-sm text-gray-500">{{ $mhs->nim }}</p>
                                    </div>
                                    <form action="{{ route('prodi.isikelas.add', $kelas->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="mahasiswa_id" value="{{ $mhs->id }}">
                                        <button type="submit" class="px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded hover:bg-green-200">
                                            Masukkan
                                        </button>
                                    </form>
                                </li>
                            @empty
                                <li class="py-3 text-center text-gray-500">
                                    @if(request('search'))
                                        Mahasiswa tidak ditemukan.
                                    @else
                                        Semua mahasiswa sudah masuk ke dalam kelas.
                                    @endif
                                </li>
                            @endforelse
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>