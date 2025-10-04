<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Edit Tahun Akademik') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            <ul class="list-disc pl-5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('jurusan.tahun-akademik.update', $tahun_akademik->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <x-input-label for="tahun_akademik" :value="__('Tahun Akademik')" />
                            <x-text-input id="tahun_akademik" name="tahun_akademik" type="text" class="block mt-1 w-full" value="{{ old('tahun_akademik', $tahun_akademik->tahun_akademik) }}" maxlength="9" pattern="\d{4}/\d{4}" placeholder="Contoh: 2025/2026" required />
                            <x-input-error :messages="$errors->get('tahun_akademik')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="semester" :value="__('Semester')" />
                            <select name="semester" id="semester" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="Ganjil" {{ old('semester', $tahun_akademik->semester) == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                <option value="Genap" {{ old('semester', $tahun_akademik->semester) == 'Genap' ? 'selected' : '' }}>Genap</option>
                            </select>
                            <x-input-error :messages="$errors->get('semester')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="status" :value="__('Status')" />
                            <select name="status" id="status" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="aktif" {{ old('status', $tahun_akademik->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="tidak_aktif" {{ old('status', $tahun_akademik->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('jurusan.tahun-akademik.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">Batal</a>
                            <x-primary-button>Simpan Perubahan</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
