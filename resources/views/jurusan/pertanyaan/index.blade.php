<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Pengelolaan Pertanyaan Kuisioner') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{
        open: @json($errors->any()),
        initForm() {
            const form = document.getElementById('pertanyaanForm');
            const pIdInput = form ? form.querySelector('#pertanyaan_id') : null;
            const pId = pIdInput ? pIdInput.value : '';
            if (this.open && pId) {
                document.getElementById('modal-title').innerText = 'Edit Pertanyaan';
                form.action = '{{ url('jurusan/pertanyaan') }}/' + pId;
                if (!form.querySelector('input[name=\'_method\']')) {
                    let methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'PUT';
                    form.appendChild(methodInput);
                }
            }
        }
    }" x-init="initForm()">
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
                            <button type="button" @click="
                                open = true;
                                let form = document.getElementById('pertanyaanForm');
                                if(form){ form.action = '{{ route('jurusan.pertanyaan.store') }}'; form.reset(); if(form.querySelector('#kuisioner_id')) form.querySelector('#kuisioner_id').value = '{{ $selectedId ?? '' }}'; }
                            " class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />
                                </svg>
                                
                                Pertanyaan
                            </button>
                        </div>
                    </div>

                    <!-- Modal Create/Edit Pertanyaan -->
                    <div x-show="open" style="display: none;" x-on:keydown.escape.window="open = false" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="open = false" aria-hidden="true"></div>
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                                <form id="pertanyaanForm" action="{{ route('jurusan.pertanyaan.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="pertanyaan_id" id="pertanyaan_id" value="{{ old('pertanyaan_id') }}">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <h3 class="font-semibold text-lg mb-4" id="modal-title">Tambah Pertanyaan Baru</h3>
                                        <div class="mt-4">
                                            <label for="kuisioner_id" class="block font-medium text-sm text-gray-700">Pilih Set Kuisioner</label>
                                            <select name="kuisioner_id" id="kuisioner_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                                <option value="">-- Pilih Wadah Kuisioner --</option>
                                                @foreach ($kuisionerOptions as $kuisioner)
                                                    <option value="{{ $kuisioner->id }}">{{ $kuisioner->sesi }} Semester {{ $kuisioner->semester }} {{ $kuisioner->tahun_akademik }}</option>
                                                @endforeach
                                            </select>
                                            @error('kuisioner_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="mt-4">
                                            <label for="isi_pertanyaan" class="block font-medium text-sm text-gray-700">Isi Pertanyaan</label>
                                            <textarea name="isi_pertanyaan" id="isi_pertanyaan" rows="3" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>{{ old('isi_pertanyaan') }}</textarea>
                                            @error('isi_pertanyaan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                            <div>
                                                <label for="tipe_jawaban" class="block font-medium text-sm text-gray-700">Tipe Jawaban</label>
                                                <select name="tipe_jawaban" id="tipe_jawaban" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                                    <option value="numerik">Numerik (Angka)</option>
                                                    <option value="boolean">Pilihan (Ya/Tidak, Sesuai/Tidak)</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label for="urutan" class="block font-medium text-sm text-gray-700">Nomor Urut Tampil</label>
                                                <input id="urutan" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" type="number" name="urutan" value="{{ old('urutan', 0) }}" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-800 text-base font-medium text-white hover:bg-gray-700 sm:ml-3 sm:w-auto sm:text-sm">Simpan</button>
                                        <button type="button" @click="open = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                                    </div>
                                </form>
                            </div>
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
                                                <button type="button" @click="
                                                    open = true;
                                                    let form = document.getElementById('pertanyaanForm');
                                                    let pData = {{ Illuminate\Support\Js::from($pertanyaan) }};
                                                    form.action = '{{ url('jurusan/pertanyaan') }}/' + pData.id;

                                                    if (!form.querySelector('input[name=_method]')) {
                                                        let methodInput = document.createElement('input');
                                                        methodInput.type = 'hidden';
                                                        methodInput.name = '_method';
                                                        methodInput.value = 'PUT';
                                                        form.appendChild(methodInput);
                                                    } else {
                                                        form.querySelector('input[name=_method]').value = 'PUT';
                                                    }

                                                    document.getElementById('modal-title').innerText = 'Edit Pertanyaan';
                                                    if(form.querySelector('#kuisioner_id')) form.querySelector('#kuisioner_id').value = pData.kuisioner_id || '';
                                                    if(form.querySelector('#isi_pertanyaan')) form.querySelector('#isi_pertanyaan').value = pData.isi_pertanyaan || '';
                                                    if(form.querySelector('#tipe_jawaban')) form.querySelector('#tipe_jawaban').value = pData.tipe_jawaban || '';
                                                    if(form.querySelector('#urutan')) form.querySelector('#urutan').value = pData.urutan || 0;
                                                    if(form.querySelector('#pertanyaan_id')) form.querySelector('#pertanyaan_id').value = pData.id;
                                                " class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                                        </svg>
                                                    </button>

                                                <form action="{{ route('jurusan.pertanyaan.destroy', $pertanyaan->id) }}" method="POST" class="inline-block ml-4">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus" onclick="return confirm('Anda yakin ingin menghapus data pertanyaan ini?')">
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