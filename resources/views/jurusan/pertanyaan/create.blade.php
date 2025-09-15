<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Tambah Pertanyaan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('jurusan.pertanyaan.store') }}" method="POST">
                        @csrf
                        
                        {{-- Dropdown untuk memilih Kuisioner (Wadah) --}}
                        <div class="mt-4">
                            <x-input-label for="kuisioner_id" :value="__('Pilih Set Kuisioner')" />
                            <select name="kuisioner_id" id="kuisioner_id" class="block mt-1 w-full border-gray-300 ... rounded-md shadow-sm" required>
                                <option value="">-- Pilih Wadah Kuisioner --</option>
                                @foreach ($kuisioners as $kuisioner)
                                    <option value="{{ $kuisioner->id }}">
                                        {{ $kuisioner->sesi }} Semester {{ $kuisioner->semester }} {{ $kuisioner->tahun_akademik }}
                                    </option>
                                @endforeach
                            </select>
                             <x-input-error :messages="$errors->get('kuisioner_id')" class="mt-2" />
                        </div>
                        
                        <div class="mt-4">
                            <x-input-label for="isi_pertanyaan" :value="__('Isi Pertanyaan')" />
                            <textarea name="isi_pertanyaan" id="isi_pertanyaan" rows="3" class="block mt-1 w-full border-gray-300 ... rounded-md shadow-sm" required>{{ old('isi_pertanyaan') }}</textarea>
                            <x-input-error :messages="$errors->get('isi_pertanyaan')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <x-input-label for="tipe_jawaban" :value="__('Tipe Jawaban')" />
                                <select name="tipe_jawaban" id="tipe_jawaban" class="block mt-1 w-full border-gray-300 ... rounded-md shadow-sm" required>
                                    <option value="numerik">Numerik (Angka)</option>
                                    <option value="boolean">Pilihan (Ya/Tidak, Sesuai/Tidak)</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="urutan" :value="__('Nomor Urut Tampil')" />
                                <x-text-input id="urutan" class="block mt-1 w-full" type="number" name="urutan" :value="old('urutan', 0)" required />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('jurusan.pertanyaan.index') }}" class="... mr-4">Batal</a>
                            <x-primary-button>Simpan</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>