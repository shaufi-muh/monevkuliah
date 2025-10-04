<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Edit Mahasiswa: ') }} {{ $mahasiswa->nama }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('prodi.mahasiswa.update', $mahasiswa->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div>
                                <label for="nim">NIM</label>
                                <input type="text" name="nim" value="{{ old('nim', $mahasiswa->nim) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            <div>
                                <label for="nama">Nama Lengkap</label>
                                <input type="text" name="nama" value="{{ old('nama', $mahasiswa->nama) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            <div>
                                <label for="email">Email</label>
                                <input type="email" name="email" value="{{ old('email', $mahasiswa->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            <div>
                                <label for="no_telp">No. Telepon</label>
                                <input type="text" name="no_telp" value="{{ old('no_telp', $mahasiswa->no_telp) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label for="status_mahasiswa" class="block font-medium text-sm text-gray-700">Status Mahasiswa (Tahun Akademik Aktif)</label>
                                <select name="status_mahasiswa" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="Aktif" {{ old('status_mahasiswa', $pivot ? $pivot->status_mahasiswa : '') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Cuti" {{ old('status_mahasiswa', $pivot ? $pivot->status_mahasiswa : '') == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                                    <option value="Non-Aktif" {{ old('status_mahasiswa', $pivot ? $pivot->status_mahasiswa : '') == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                                </select>
                                @error('status_mahasiswa') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="mt-4 flex items-center gap-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border rounded-md font-semibold text-xs text-white uppercase hover:bg-gray-700">
                                Update
                            </button>
                            <a href="{{ route('prodi.mahasiswa.index') }}" class="text-gray-600 hover:underline">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>