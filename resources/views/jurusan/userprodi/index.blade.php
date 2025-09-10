<x-app-layout>
    {{-- Slot untuk Judul Halaman --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengelolaan User Program Studi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    {{-- Pesan Sukses --}}
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h3 class="font-semibold text-lg mb-4">Tambah User Prodi Baru</h3>
                    <form action="{{ route('jurusan.userprodi.store') }}" method="POST">
                        @csrf
                        <!--<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4"> bagi 4-->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
                            <div class="mt-4">
                                <x-input-label for="name" :value="__('Nama Pengguna')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                        
                            <div class="mt-4">
                                <x-input-label for="prodi_id" value="Pilih Prodi" />
                                <select name="prodi_id" id="prodi_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Pilih Prodi</option>
                                    @foreach ($prodis as $prodi)
                                        <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('prodi_id')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="email" :value="__('Alamat Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="password" :value="__('Password')" />
                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                            </div>

                            <div class="mt-11"> <!-- flex items-center justify-end DIHILANGKAN--> 
                                <x-primary-button>
                                    {{ __('Simpan') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </form>

                    <hr class="my-8">

                    <h3 class="font-semibold text-lg mb-4">Daftar Prodi</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                  <!--  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th> -->
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pengguna</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program Studi</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($users as $user)
                                    <tr>
                                        <!-- <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td> -->
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->prodi->nama_prodi ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-3">
                                                <a href="{{ route('jurusan.userprodi.edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('jurusan.userprodi.destroy', $user->id) }}" method="POST" class="inline ml-4">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus" onclick="return confirm('Anda yakin ingin menghapus data dosen ini?')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.134-2.09-2.134H8.09c-1.18 0-2.09.954-2.09 2.134v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                            Belum ada data user prodi.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div> 

                </div>
            </div>
        </div>
    </div>
</x-app-layout>