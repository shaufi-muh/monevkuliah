<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Dosen: ') }} {{ $dosen->nama_dosen }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('prodi.dosen.update', $dosen->id) }}" method="POST">
                        @csrf
                        @method('PATCH') <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="nama_dosen" class="block font-medium text-sm text-gray-700">Nama Dosen</label>
                                <input type="text" name="nama_dosen" id="nama_dosen" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('nama_dosen', $dosen->nama_dosen) }}" required>
                                @error('nama_dosen') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="prodi_id" class="block font-medium text-sm text-gray-700">Homebase (Prodi)</label>
                                <select name="prodi_id" id="prodi_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                    <option value="">Pilih Prodi</option>
                                    @foreach ($prodis as $prodi)
                                        <option value="{{ $prodi->id }}" @selected(old('prodi_id', $dosen->prodi_id) == $prodi->id)>
                                            {{ $prodi->nama_prodi }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('prodi_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="nip" class="block font-medium text-sm text-gray-700">NIP</label>
                                <input type="text" name="nip" id="nip" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('nip', $dosen->nip) }}">
                                @error('nip') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="nuptk" class="block font-medium text-sm text-gray-700">NUPTK</label>
                                <input type="text" name="nuptk" id="nuptk" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('nuptk', $dosen->nuptk) }}">
                                @error('nuptk') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mt-4 flex items-center gap-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Update
                            </button>
                            <a href="{{ route('prodi.dosen.index') }}" class="text-gray-600 hover:underline">Batal</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>