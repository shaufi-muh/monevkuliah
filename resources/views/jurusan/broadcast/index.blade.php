<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Broadcast Tautan Evaluasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Kirim Tautan Evaluasi ke Mahasiswa</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Pilih kuisioner dan target mahasiswa untuk mengirimkan tautan pengisian evaluasi unik.
                    </p>

                    <form action="{{ route('jurusan.broadcast.send') }}" method="POST" class="mt-6 space-y-6">
                        @csrf

                        {{-- BAGIAN 1: KUISIONER AKTIF (TAMPILAN OTOMATIS) --}}
                        <div>
                            <x-input-label value="Kuisioner Aktif" />
                            @if ($kuisionerAktif)
                                <div class="mt-2 p-3 bg-green-50 border border-green-200 rounded-md">
                                    <p class="font-semibold text-green-800">
                                        {{ $kuisionerAktif->sesi }} Semester {{ $kuisionerAktif->semester }} {{ $kuisionerAktif->tahun_akademik }}
                                    </p>
                                    <p class="text-sm text-gray-600">{{ $kuisionerAktif->deskripsi }}</p>
                                </div>
                                {{-- Simpan ID kuisioner secara tersembunyi --}}
                                <input type="hidden" name="kuisioner_id" value="{{ $kuisionerAktif->id }}">
                            @else
                                <div class="mt-2 p-3 bg-red-50 border border-red-200 rounded-md">
                                    <p class="font-semibold text-red-800">
                                        Tidak ada kuisioner yang aktif.
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        Silakan aktifkan salah satu set kuisioner di menu "Set Kuisioner" terlebih dahulu.
                                    </p>
                                </div>
                            @endif
                        </div>


                        
                        {{-- BAGIAN 3: PROGRAM STUDI (CHECKBOX) --}}
                        <div>
                            <x-input-label value="Pilih Program Studi (bisa lebih dari satu)" />
                            <div class="mt-2 space-y-2 border border-gray-200 rounded-md p-4">
                                @forelse ($prodiList as $prodi)
                                    <label for="prodi_{{ $prodi->id }}" class="flex items-center">
                                        {{-- KUNCI: name="prodi_ids[]" menggunakan kurung siku --}}
                                        <input type="checkbox" id="prodi_{{ $prodi->id }}" name="prodi_ids[]" value="{{ $prodi->id }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-600">{{ $prodi->nama_prodi }}</span>
                                    </label>
                                @empty
                                    <p class="text-sm text-gray-500">Tidak ada data program studi ditemukan.</p>
                                @endforelse
                            </div>
                             <x-input-error class="mt-2" :messages="$errors->get('prodi_ids')" />
                        </div>

                        {{-- TOMBOL SUBMIT --}}
                        <div class="flex items-center">
                            <x-primary-button :disabled="!$kuisionerAktif">
                                {{ __('Generate & Kirim Tautan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>