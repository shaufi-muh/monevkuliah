<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Data Dosen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <h3 class="font-semibold text-lg mb-4">Tambah Dosen Baru</h3>
                    <form action="{{ route('prodi.dosen.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="nama_dosen" class="block font-medium text-sm text-gray-700">Nama Dosen</label>
                                <input type="text" name="nama_dosen" id="nama_dosen" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('nama_dosen') }}" required>
                                @error('nama_dosen') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="prodi_id" class="block font-medium text-sm text-gray-700">Homebase (Prodi)</label>
                                <select name="prodi_id" id="prodi_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                    <option value="">Pilih Prodi</option>
                                    @foreach ($prodis as $prodi)
                                        <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}</option>
                                    @endforeach
                                </select>
                                @error('prodi_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="NIP" class="block font-medium text-sm text-gray-700">NIP</label>
                                <input type="text" name="NIP" id="NIP" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('NIP') }}">
                                @error('NIP') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="NUPTK" class="block font-medium text-sm text-gray-700">NUPTK</label>
                                <input type="text" name="NUPTK" id="NUPTK" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('NUPTK') }}">
                                @error('NUPTK') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Simpan
                            </button>
                        </div>
                    </form>

                    <hr class="my-8">

                    <h3 class="font-semibold text-lg mb-4">Daftar Dosen</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIP</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Homebase</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($dosens as $dosen)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $dosen->nama_dosen }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $dosen->NIP ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $dosen->prodi->nama_prodi }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <a href="#" class="text-red-600 hover:text-red-900 ml-4">Hapus</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                            Data belum tersedia.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $dosens->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>