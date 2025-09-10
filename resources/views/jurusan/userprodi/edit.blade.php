<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User Prodi: ') }} {{ $userprodi->nama_prodi }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Form untuk mengedit data --}}
                    <form action="{{ route('jurusan.userprodi.update', $userprodi->id) }}" method="POST">
                        @csrf
                        @method('PUT') {{-- Direktif Blade untuk metode PUT --}}

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
                            
                            {{-- Nama Pengguna --}}
                            <div class="mt-4">
                                <x-input-label for="name" :value="__('Nama Pengguna')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $userprodi->name)" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                        
                            {{-- Pilihan Program Studi --}}
                            <div class="mt-4">
                                <x-input-label for="prodi_id" value="Pilih Prodi" />
                                <select name="prodi_id" id="prodi_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Pilih Prodi</option>
                                    @foreach ($prodis as $prodi)
                                        <option value="{{ $prodi->id }}" {{ old('prodi_id', $userprodi->prodi_id) == $prodi->id ? 'selected' : '' }}>
                                            {{ $prodi->nama_prodi }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('prodi_id')" class="mt-2" />
                            </div>

                            {{-- Alamat Email --}}
                            <div class="mt-4">
                                <x-input-label for="email" :value="__('Alamat Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $userprodi->email)" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            {{-- Password Baru --}}
                            <div class="mt-4">
                                <x-input-label for="password" :value="__('Password Baru')" />
                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" />
                                <small class="text-gray-500">Kosongkan jika tidak ingin mengubah password.</small>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            {{-- Konfirmasi Password Baru --}}
                            <div class="mt-4">
                                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')" />
                                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" />
                            </div>

                            {{-- Tombol Update dan Batal --}}
                            <div class="mt-11">
                                <x-primary-button>
                                    {{ __('Update') }}
                                </x-primary-button>
                                <a href="{{ route('jurusan.userprodi.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300">
                                    Batal
                                </a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>