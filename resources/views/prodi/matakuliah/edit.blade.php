<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Edit Mata Kuliah: ') }} {{ $matakuliah->nama_matkul }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('prodi.matakuliah.update', $matakuliah->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                           <div>
                                <label for="kode_matkul">Kode MK</label>
                                <input type="text" name="kode_matkul" value="{{ old('kode_matkul', $matakuliah->kode_matkul) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            <div>
                                <label for="nama_matkul">Nama Mata Kuliah</label>
                                <input type="text" name="nama_matkul" value="{{ old('nama_matkul', $matakuliah->nama_matkul) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            <div>
                                <label for="sks">SKS</label>
                                <input type="number" name="sks" value="{{ old('sks', $matakuliah->sks) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            <div>
                                <label for="semester">Semester</label>
                                <input type="number" name="semester" value="{{ old('semester', $matakuliah->semester) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center gap-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border rounded-md font-semibold text-xs text-white uppercase hover:bg-gray-700">
                                Update
                            </button>
                            <a href="{{ route('prodi.matakuliah.index') }}" class="text-gray-600 hover:underline">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>