<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengelolaan Pertanyaan Kuisioner') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        {{-- Form untuk Filter Dropdown --}}
                    <!--    <form action="{{ route('jurusan.pertanyaan.index') }}" method="GET" class="flex-grow"> -->
                        <form action="{{ route('jurusan.pertanyaan.index') }}" method="GET">
                            <div class="inline-block relative w-72">
                                <select name="kuisioner_id" onchange="this.form.submit()" class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">-- Pilih Set Kuisioner --</option>
                                    @foreach ($kuisionerOptions as $kuisioner)
                                        <option value="{{ $kuisioner->id }}" {{ $selectedId == $kuisioner->id ? 'selected' : '' }}>
                                            {{ $kuisioner->sesi }} Semester {{ $kuisioner->semester }} {{ $kuisioner->tahun_akademik }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>

                        {{-- Tombol Tambah Pertanyaan --}}
                        <div class="mb-4 text-center">
                            <a href="{{ route('jurusan.pertanyaan.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />
                                </svg>
                                
                                Pertanyaan
                            </a>
                        </div>
                    </div>
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 ...">{{ session('success') }}</div>
                    @endif

             

                    {{-- Tampilkan tabel HANYA jika ada kuisioner yang dipilih --}}
                    @if($selectedKuisioner)
                        <div class="mt-6 p-4 border rounded-lg">
                            <h3 class="font-semibold text-lg text-gray-800">
                                Daftar Pertanyaan untuk: {{ $selectedKuisioner->sesi }} Semester {{ $selectedKuisioner->semester }} {{ $selectedKuisioner->tahun_akademik }}
                            </h3>
                            <p class="text-sm text-gray-500 mb-3">{{ $selectedKuisioner->deskripsi }}</p>
                            {{-- Tabel untuk Pertanyaan di dalam Set (Isi) --}}
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left ...">Urutan</th>
                                        <th class="px-4 py-2 text-left ...">Isi Pertanyaan</th>
                                        <th class="px-4 py-2 text-left ...">Tipe Jawaban</th>
                                        <th class="px-4 py-2 text-left ...">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <!--    ($kuisioner->pertanyaans as $pertanyaan) -->
                                    @forelse ($pertanyaans as $pertanyaan)  
                                        <tr>
                                            <td class="px-4 py-2">{{ $pertanyaan->urutan }}</td>
                                            <td class="px-4 py-2">{{ $pertanyaan->isi_pertanyaan }}</td>
                                            <td class="px-4 py-2">{{ Str::ucfirst($pertanyaan->tipe_jawaban) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center space-x-3">
                                                <a href="{{ route('jurusan.pertanyaan.edit', $pertanyaan->id) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                                    </svg>
                                                </a>

                                                <form action="{{ route('jurusan.pertanyaan.destroy', $pertanyaan->id) }}" method="POST" class="inline-block ml-4">
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
                                            <td colspan="4" class="text-center text-gray-500 py-3">
                                                Belum ada pertanyaan di dalam set ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>    
                    @else
                        <div class="text-center text-gray-500 py-10">
                                <p>Silakan pilih set kuisioner untuk menampilkan pertanyaannya.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>