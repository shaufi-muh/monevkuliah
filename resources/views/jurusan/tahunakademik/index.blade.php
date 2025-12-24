<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Daftar Tahun Akademik') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{
        open: @json($errors->any()),
        initForm() {
            const form = document.getElementById('taForm');
            const taIdInput = form ? form.querySelector('#ta_id') : null;
            const taId = taIdInput ? taIdInput.value : '';
            if (this.open && taId) {
                document.getElementById('modal-title').innerText = 'Edit Tahun Akademik';
                form.action = '{{ url('jurusan/tahun-akademik') }}/' + taId;
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
                        <span class="text-lg font-bold">
                            @if(session('success'))
                        <div class="mb-2 p-2 bg-green-100 border-green-400 text-green-700 rounded" role="alert">
                            {{ session('success') }}
                        </div>
                            @endif
                        </span>
                        <button type="button" @click="
                            open = true;
                            let form = document.getElementById('taForm');
                            if(form){ form.action = '{{ route('jurusan.tahun-akademik.store') }}'; form.reset(); }
                        " class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:border-green-700 focus:ring ring-green-300 transition ease-in-out duration-150" title="Tambah Tahun Akademik Baru">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 -ml-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5v6m3-3H9m4.06-7.19-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                            </svg>
                            Tahun Akademik
                        </button>
                    </div>
                    <!-- Modal Create Tahun Akademik -->
                    <div x-show="open" style="display: none;" x-on:keydown.escape.window="open = false" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="open = false" aria-hidden="true"></div>
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                                <form id="taForm" action="{{ route('jurusan.tahun-akademik.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="ta_id" id="ta_id" value="{{ old('ta_id') }}">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <h3 class="font-semibold text-lg mb-4" id="modal-title">Tambah Tahun Akademik Baru</h3>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label for="tahun_akademik" class="block font-medium text-sm text-gray-700">Tahun Akademik</label>
                                                <input id="tahun_akademik" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" type="text" name="tahun_akademik" value="{{ old('tahun_akademik') }}" required placeholder="Contoh: 2025/2026" />
                                                @error('tahun_akademik') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>
                                            <div>
                                                <label for="semester" class="block font-medium text-sm text-gray-700">Semester</label>
                                                <select name="semester" id="semester" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                                    <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                                    <option value="Genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mt-6">
                                            <label for="status" class="block font-medium text-sm text-gray-700">Status Awal</label>
                                            <select name="status" id="status" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                                <option value="tidak_aktif" {{ old('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                            </select>
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
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tahun Akademik</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semester</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($tahunAkademiks as $ta)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $ta->tahun_akademik }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $ta->semester }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center space-x-3">
                                                @if($ta->status == 'aktif')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tidak Aktif</span>
                                                @endif
                                                <form action="{{ route('jurusan.tahun-akademik.toggleStatus', $ta->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="checkbox"
                                                        class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer"
                                                        onchange="this.form.submit()"
                                                        @if($ta->status == 'aktif') checked @endif
                                                        title="Ubah Status">
                                                </form>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-3">
                                            <button type="button" @click="
                                                open = true;
                                                let form = document.getElementById('taForm');
                                                let taData = {{ Illuminate\Support\Js::from($ta) }};
                                                form.action = '{{ url('jurusan/tahun-akademik') }}/' + taData.id;

                                                if (!form.querySelector('input[name=_method]')) {
                                                    let methodInput = document.createElement('input');
                                                    methodInput.type = 'hidden';
                                                    methodInput.name = '_method';
                                                    methodInput.value = 'PUT';
                                                    form.appendChild(methodInput);
                                                } else {
                                                    form.querySelector('input[name=_method]').value = 'PUT';
                                                }

                                                document.getElementById('modal-title').innerText = 'Edit Tahun Akademik';
                                                form.querySelector('#tahun_akademik').value = taData.tahun_akademik || '';
                                                form.querySelector('#semester').value = taData.semester || '';
                                                form.querySelector('#status').value = taData.status || '';
                                                form.querySelector('#ta_id').value = taData.id;
                                            " class="text-indigo-600 hover:text-indigo-900 mr-2" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                                </svg>
                                            </button>
                                            <form action="{{ route('jurusan.tahun-akademik.destroy', $ta->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin ingin menghapus tahun akademik ini?')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">Belum ada data tahun akademik.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
