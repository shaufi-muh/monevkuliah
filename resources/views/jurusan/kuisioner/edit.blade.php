<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Set Kuisioner') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="font-semibold text-lg mb-4">
                        Mengedit: Kuisioner {{ $kuisioner->sesi }} Semester {{ $kuisioner->semester }} {{ $kuisioner->tahun_akademik }}
                    </h3>
                    <form action="{{ route('jurusan.kuisioner.update', $kuisioner->id) }}" method="POST">
                        @csrf
                        @method('PUT') {{-- Wajib untuk form edit --}}
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="tahun_akademik" :value="__('Tahun Akademik')" />
                                <x-text-input id="tahun_akademik" class="block mt-1 w-full" name="tahun_akademik" :value="old('tahun_akademik', $kuisioner->tahun_akademik)" maxlength="9" pattern="\d{4}\/\d{4}" placeholder="Contoh: 2024/2025" title="Harap masukkan format tahun yang benar (Contoh: 2024/2025)" required />
                                <x-input-error :messages="$errors->get('tahun_akademik')" class="mt-2" />
                            </div>
                        <!--    <div>
                                <x-input-label for="tahun_akademik" :value="__('Tahun Akademik')" />
                                <x-text-input id="tahun_akademik" class="block mt-1 w-full" name="tahun_akademik" :value="old('tahun_akademik', $kuisioner->tahun_akademik)"  maxlength="9" pattern="\d{4}\/\d{4}" placeholder="Contoh: 2024/2025" title="Harap masukkan format tahun yang benar (Contoh: 2024/2025)" required />  
                                <x-input-error :messages="$errors->get('tahun_akademik')" class="mt-2" />
                            </div> -->
                            <div>
                                <x-input-label for="semester" :value="__('Semester')" />
                                <select name="semester" id="semester" class="block mt-1 w-full border-gray-300 ... rounded-md shadow-sm">
                                    <option value="Ganjil" {{ old('semester', $kuisioner->semester) == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                    <option value="Genap" {{ old('semester', $kuisioner->semester) == 'Genap' ? 'selected' : '' }}>Genap</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="sesi" :value="__('Sesi')" />
                                <select name="sesi" id="sesi" class="block mt-1 w-full border-gray-300 ... rounded-md shadow-sm">
                                    <option value="Tengah" {{ old('sesi', $kuisioner->sesi) == 'Tengah' ? 'selected' : '' }}>Tengah Semester</option>
                                    <option value="Akhir" {{ old('sesi', $kuisioner->sesi) == 'Akhir' ? 'selected' : '' }}>Akhir Semester</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="deskripsi" :value="__('Deskripsi (Opsional)')" />
                            <textarea name="deskripsi" id="deskripsi" class="block mt-1 w-full border-gray-300 ... rounded-md shadow-sm">{{ old('deskripsi', $kuisioner->deskripsi) }}</textarea>
                        </div>
                        <div class="mt-4">
                            <x-input-label for="status" :value="__('Status')" />
                            <select name="status" id="status" class="block mt-1 w-full border-gray-300 ... rounded-md shadow-sm">
                                <option value="tidak_aktif" {{ old('status', $kuisioner->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                <option value="aktif" {{ old('status', $kuisioner->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            </select>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('jurusan.kuisioner.index') }}" class="... mr-4">Batal</a>
                            <x-primary-button>Update</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>