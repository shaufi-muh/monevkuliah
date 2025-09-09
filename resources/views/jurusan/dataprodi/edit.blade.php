<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Prodi: ') }} {{ $dataprodi->nama_prodi }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('jurusan.dataprodi.update', $dataprodi->id) }}" method="POST">
                        @csrf
                        @method('PATCH') <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="nama_prodi" class="block font-medium text-sm text-gray-700">Nama Prodi</label>
                            <input type="text" name="nama_prodi" id="nama_prodi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" 
                                value="{{ old('nama_prodi', $dataprodi->nama_prodi) }}" required>
                            @error('nama_prodi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>    
                       <!-- <div>
                                <label for="nama_prodi" class="block font-medium text-sm text-gray-700">Nama Prodi</label>
                                    <select name="nama_prodi" id="nama_prodi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                        <option value="">Pilih Prodi</option>
                                        @foreach ($prodis as $prodi)
                                            <option value="{{ $prodi->nama_prodi}}" @selected(old('nama_prodi', $dataprodi->id) == $prodi->id)>
                                                {{ $prodi->nama_prodi }}
                                            </option>
                                        @endforeach
                                 </select>
                                <select name="nama_prodi" id="nama_prodi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                    <option value="">Pilih Prodi</option>
                                    
                                    {{-- Gunakan variabel baru: $prodi_option --}}
                                    @foreach ($prodis as $prodi_option)
                                        <option value="{{ $prodi_option->id }}" 
                                                @selected(old('nama_prodi', $prodi_option->nama_prodi) == $prodi_option->nama_prodi)>
                                            {{ $prodi_option->nama_prodi }}
                                        </option>
                                    @endforeach
                                    
                                </select> 
                                @error('prodi_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div> -->

                            <div>
                                <label for="kode_prodi" class="block font-medium text-sm text-gray-700">Kode Prodi</label>
                                <input type="text" name="kode_prodi" id="kode_prodi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('kode_prodi', $dataprodi->kode_prodi) }}">
                                @error('kode_prodi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>                        

                            <div>
                                <label for="akronim_prodi" class="block font-medium text-sm text-gray-700">Akronim Prodi</label>
                                <input type="text" name="akronim_prodi" id="akronim_prodi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('akronim_prodi', $dataprodi->akronim_prodi) }}">
                                @error('akronim_prodi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mt-4 flex items-center gap-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Update
                            </button>
                            <a href="{{ route('jurusan.dataprodi.index') }}" class="text-gray-600 hover:underline">Batal</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>