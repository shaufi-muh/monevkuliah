<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Kelola Data Mata Kuliah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h3 class="font-semibold text-lg mb-4">Tambah Mata Kuliah Baru</h3>
                    <form action="{{ route('prodi.matakuliah.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div>
                                <label for="kode_matkul" class="block font-medium text-sm text-gray-700">Kode MK</label>
                                <input type="text" name="kode_matkul" value="{{ old('kode_matkul') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                @error('kode_matkul') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="nama_matkul" class="block font-medium text-sm text-gray-700">Nama Mata Kuliah</label>
                                <input type="text" name="nama_matkul" value="{{ old('nama_matkul') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                @error('nama_matkul') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="sks" class="block font-medium text-sm text-gray-700">SKS</label>
                                <input type="number" name="sks" value="{{ old('sks') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                @error('sks') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="semester" class="block font-medium text-sm text-gray-700">Semester</label>
                                <input type="number" name="semester" value="{{ old('semester') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                @error('semester') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border rounded-md font-semibold text-xs text-white uppercase hover:bg-gray-700">
                                Simpan
                            </button>
                        </div>
                    </form>

                    <hr class="my-8">

                    <h3 class="font-semibold text-lg mb-4">Daftar Mata Kuliah</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Mata Kuliah</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">SKS</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Semester</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($mata_kuliahs as $matkul)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $matkul->kode_matkul }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $matkul->nama_matkul }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $matkul->sks }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $matkul->semester }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-3">
                                                <a href="{{ route('prodi.matakuliah.edit', $matkul->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('prodi.matakuliah.destroy', $matkul->id) }}" method="POST" class="inline-block ml-4">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Anda yakin ingin menghapus data ini?')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.134-2.09-2.134H8.09c-1.18 0-2.09.954-2.09 2.134v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </button>
                                            </form>
                                            </div>
                                        </td>                   
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            Data belum tersedia.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $mata_kuliahs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>