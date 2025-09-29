<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Buat Set Kuisioner Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('jurusan.kuisioner.store') }}" method="POST">
                        @csrf
                        {{-- Baris untuk input Tahun Akademik, Semester, dan Sesi --}}
                        <!-- Menampilkan logika jika ada ada  tahun akademik aktif 
                        <div class="mb-4">
                            <div class="p-3 bg-blue-50 border border-blue-200 rounded mb-2">
                                <span class="font-semibold">Tahun Akademik Aktif:</span>
                                @if($tahunAkademikAktif)
                                    <span class="ml-2">{{ $tahunAkademikAktif->tahun_akademik }} ({{ $tahunAkademikAktif->semester }})</span>
                                    <input type="hidden" name="tahun_akademik" value="{{ $tahunAkademikAktif->tahun_akademik }}">
                                    <input type="hidden" name="semester" value="{{ $tahunAkademikAktif->semester }}">
                                @else
                                    <span class="ml-2 text-red-600">Belum ada tahun akademik aktif!</span>
                                @endif
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="sesi" :value="__('Sesi')" />
                                <select name="sesi" id="sesi" class="block mt-1 w-full border-gray-300 ... rounded-md shadow-sm">
                                    <option value="Tengah">Tengah Semester</option>
                                    <option value="Akhir">Akhir Semester</option>
                                </select>
                            </div>
                        </div>
                        -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="tahun_akademik" :value="__('Tahun Akademik')" />
                                <x-text-input id="tahun_akademik" class="block mt-1 w-full" name="tahun_akademik" :value="old('tahun_akademik')"  maxlength="9" pattern="\d{4}\/\d{4}" placeholder="Contoh: 2024/2025" title="Harap masukkan format tahun yang benar (Contoh: 2024/2025)" required /> <!-- type="number" , date('Y') --> 
                                <x-input-error :messages="$errors->get('tahun_akademik')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="semester" :value="__('Semester')" />
                                <select name="semester" id="semester" class="block mt-1 w-full border-gray-300 ... rounded-md shadow-sm">
                                    <option value="Ganjil">Ganjil</option>
                                    <option value="Genap">Genap</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="sesi" :value="__('Sesi')" />
                                <select name="sesi" id="sesi" class="block mt-1 w-full border-gray-300 ... rounded-md shadow-sm">
                                    <option value="Tengah">Tengah Semester</option>
                                    <option value="Akhir">Akhir Semester</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-input-label for="deskripsi" :value="__('Deskripsi (Opsional)')" />
                            <textarea name="deskripsi" id="deskripsi" class="block mt-1 w-full border-gray-300 ... rounded-md shadow-sm">{{ old('deskripsi') }}</textarea>
                        </div>
                        <div class="mt-4">
                            <x-input-label for="status" :value="__('Status Awal')" />
                            <select name="status" id="status" class="block mt-1 w-full border-gray-300 ... rounded-md shadow-sm">
                                <option value="tidak_aktif">Tidak Aktif</option>
                                <option value="aktif">Aktif</option>
                            </select>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('jurusan.kuisioner.index') }}" class="... mr-4">Batal</a>
                            <x-primary-button>Simpan</x-primary-button>
                        </div>
                        <!-- Tombol Simpan dan Batal jika ada logika tahun akademik aktif 
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('jurusan.kuisioner.index') }}" class="... mr-4">Batal</a>
                            @if(!$tahunAkademikAktif)
                                <span class="text-red-600 font-semibold mr-4">Tidak bisa menyimpan, belum ada tahun akademik aktif!</span>
                                <button type="button" class="bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed" disabled>Simpan</button>
                            @else
                                <x-primary-button>Simpan</x-primary-button>
                            @endif
                        </div>-->
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>