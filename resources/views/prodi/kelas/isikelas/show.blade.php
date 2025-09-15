<x-app-layout>
    <x-slot name="header">
        <h2>
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
                <div class="p-6 text-gray-900">
                    <!-- Tabs -->
                    <div class="mb-6 border-b border-gray-200">
                        <nav class="flex space-x-8" aria-label="Tabs">
                            <a href="{{ route('prodi.isikelas.show', [$kelas->id, 'tab' => 'mahasiswa']) }}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ ($tab == 'mahasiswa') ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                Tambahkan Mahasiswa
                            </a>
                            <a href="{{ route('prodi.isikelas.show', [$kelas->id, 'tab' => 'matkul']) }}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ ($tab == 'matkul') ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                Tambahkan Mata Kuliah
                            </a>
                        </nav>
                    </div>

                    @if ($tab == 'mahasiswa')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
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
                                <input type="hidden" name="tab" value="mahasiswa">
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
                    @elseif ($tab == 'matkul')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold text-lg mb-4">Mata Kuliah di Kelas Ini ({{ $kelas->mataKuliahs->count() }})</h3>
                            <ul class="divide-y divide-gray-200 max-h-96 overflow-y-auto">
                                @forelse ($kelas->mataKuliahs as $matkul)
                                    <li class="py-3 flex items-center justify-between">
                                        <div>
                                            <p class="font-medium">{{ $matkul->nama_matkul }}</p>
                                            <p class="text-sm text-gray-500">{{ $matkul->kode_matkul }} | {{ $matkul->sks }} SKS</p>
                                        </div>
                                        <form action="{{ route('prodi.isikelas.removeMatkul', $kelas->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="mata_kuliah_id" value="{{ $matkul->id }}">
                                            <button type="submit" class="px-2 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded hover:bg-red-200">
                                                Hapus
                                            </button>
                                        </form>
                                    </li>
                                @empty
                                    <li class="py-3 text-center text-gray-500">Belum ada mata kuliah di kelas ini.</li>
                                @endforelse
                            </ul>
                        </div>

                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold text-lg mb-4">Mata Kuliah yang Tersedia (Semester {{ $kelas->urutan_semester }})</h3>
                            <form method="GET" action="{{ route('prodi.isikelas.show', $kelas->id) }}" class="mb-4">
                                <input type="hidden" name="tab" value="matkul">
                                <div class="flex">
                                    <input type="text" name="search_matkul" placeholder="Cari Nama atau Kode Mata Kuliah..." class="flex-grow rounded-l-md border-gray-300 shadow-sm" value="{{ request('search_matkul') }}">
                                    <button type="submit" class="px-4 py-2 bg-gray-800 border rounded-r-md font-semibold text-xs text-white uppercase hover:bg-gray-700">
                                        Cari
                                    </button>
                                </div>
                            </form>
                            <ul class="divide-y divide-gray-200 max-h-96 overflow-y-auto">
                                @forelse ($matkulTersedia as $matkul)
                                    <li class="py-3 flex items-center justify-between">
                                        <div>
                                            <p class="font-medium">{{ $matkul->nama_matkul }}</p>
                                            <p class="text-sm text-gray-500">{{ $matkul->kode_matkul }} | {{ $matkul->sks }} SKS</p>
                                        </div>
                                        <form action="{{ route('prodi.isikelas.addMatkul', $kelas->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="mata_kuliah_id" value="{{ $matkul->id }}">
                                            <button type="submit" class="px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded hover:bg-green-200">
                                                Masukkan
                                            </button>
                                        </form>
                                    </li>
                                @empty
                                    <li class="py-3 text-center text-gray-500">
                                        @if(request('search_matkul'))
                                            Mata kuliah tidak ditemukan.
                                        @else
                                            Semua mata kuliah semester ini sudah masuk ke dalam kelas.
                                        @endif
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>