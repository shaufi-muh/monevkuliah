<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Edit Tahun Akademik') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('jurusan.tahun-akademik.update', $tahun_akademik->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="tahun_akademik" value="Tahun Akademik" />
                                <x-text-input id="tahun_akademik" class="block mt-1 w-full" type="text" name="tahun_akademik" :value="old('tahun_akademik', $tahun_akademik->tahun_akademik)" required />
                                <x-input-error :messages="$errors->get('tahun_akademik')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="semester" value="Semester" />
                                <select name="semester" id="semester" class="block mt-1 w-full border-gray-300 ... rounded-md shadow-sm">
                                    <option value="Ganjil" {{ old('semester', $tahun_akademik->semester) == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                    <option value="Genap" {{ old('semester', $tahun_akademik->semester) == 'Genap' ? 'selected' : '' }}>Genap</option>
                                </select>
                            </div>
                            <div class="mt-4">
                            <x-input-label for="status" :value="__('Status')" />
                            <select name="status" id="status" class="block mt-1 w-full border-gray-300 ... rounded-md shadow-sm">
                                <option value="tidak_aktif" {{ old('status', $tahun_akademik->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                <option value="aktif" {{ old('status', $tahun_akademik->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            </select>
                        </div>
                        </div>
                        <div class="mt-4 flex items-center gap-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Update
                            </button>
                            <a href="{{ route('jurusan.tahun-akademik.index') }}" class="text-gray-600 hover:underline">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>