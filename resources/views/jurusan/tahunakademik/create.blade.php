<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Tambah Tahun Akademik Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('jurusan.tahun-akademik.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="tahun_akademik" value="Tahun Akademik" />
                                <x-text-input id="tahun_akademik" class="block mt-1 w-full" type="text" name="tahun_akademik" :value="old('tahun_akademik')" required placeholder="Contoh: 2025/2026" />
                                <x-input-error :messages="$errors->get('tahun_akademik')" class="mt-2" />
                            </div>
                             <div>
                                <x-input-label for="tahun" value="Tahun" />
                                <select name="tahun" id="tahun" class="block mt-1 w-full border-gray-300 ... rounded-md shadow-sm">
                                    <option value="Ganjil">Ganjil</option>
                                    <option value="Genap">Genap</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-6">
                            <x-input-label for="status" value="Status Awal" />
                            <select name="status" id="status" class="block mt-1 w-full border-gray-300 ... rounded-md shadow-sm">
                                <option value="tidak_aktif">Tidak Aktif</option>
                                <option value="aktif">Aktif</option>
                            </select>
                        </div>
                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('jurusan.tahun-akademik.index') }}" class="... mr-4">Batal</a>
                            <x-primary-button>Simpan</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>