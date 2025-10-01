
<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Tambah Mata Kuliah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('prodi.matakuliah.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div>
                                <label for="kode_matkul">Kode MK</label>
                                <input type="text" name="kode_matkul" value="{{ old('kode_matkul') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                @error('kode_matkul') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="nama_matkul">Nama Mata Kuliah</label>
                                <input type="text" name="nama_matkul" value="{{ old('nama_matkul') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                @error('nama_matkul') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="sks">SKS</label>
                                <input type="number" name="sks" value="{{ old('sks') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                @error('sks') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="urutan_semester">Semester Ke-</label>
                                <input type="number" name="urutan_semester" value="{{ old('urutan_semester') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                @error('urutan_semester') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="dosen_pengampu">Dosen Pengampu</label>
                            <select name="dosen_pengampu[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" multiple required>
                                @foreach($dosens as $dosen)
                                    <option value="{{ $dosen->id }}">{{ $dosen->nama_dosen }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Tekan Ctrl (atau Cmd di Mac) untuk memilih lebih dari satu dosen.</small>
                            @error('dosen_pengampu') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div class="mt-4 flex items-center gap-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border rounded-md font-semibold text-xs text-white uppercase hover:bg-gray-700">
                                Simpan
                            </button>
                            <a href="{{ route('prodi.matakuliah.index') }}" class="text-gray-600 hover:underline">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
