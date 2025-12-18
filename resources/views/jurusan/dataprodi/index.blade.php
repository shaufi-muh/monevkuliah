<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Kelola Data Prodi') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{
    open: @json($errors->any()),
    initForm() {
        const form = document.getElementById('dataprodiForm');
        const dpIdInput = form ? form.querySelector('#dataprodi_id') : null;
        const dpId = dpIdInput ? dpIdInput.value : '';
        if (this.open && dpId) {
            document.getElementById('modal-title').innerText = 'Edit Data Prodi';
            form.action = '{{ url('jurusan/dataprodi') }}/' + dpId;
            if (!form.querySelector('input[name=\'_method\']')) {
                let methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PUT';
                form.appendChild(methodInput);
            }
        }
    }
}"
    x-init="initForm()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Pesan SUKSES akan memiliki background HIJAU --}}
                    @if (session('success'))
                        <div class="mb-4 rounded-lg bg-green-100 px-4 py-3 text-green-700 border border-green-400" role="alert">
                            <strong class="font-bold">Berhasil!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    {{-- Pesan ERROR akan memiliki background MERAH --}}
                    @if (session('error'))
                        <div class="mb-4 rounded-lg bg-red-100 px-4 py-3 text-red-700 border border-red-400" role="alert">
                            <strong class="font-bold">Gagal!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-4">
                        <button @click="
                            open = true;
                            let form = document.getElementById('dataprodiForm');
                            form.action = '{{ route('jurusan.dataprodi.store') }}';
                            if (form.querySelector('input[name=_method]')) {
                                form.querySelector('input[name=_method]').remove();
                            }
                            form.reset();
                            document.getElementById('modal-title').innerText = 'Tambah Prodi Baru';
                            if (form.querySelector('#dataprodi_id')) form.querySelector('#dataprodi_id').value = '';
                        " class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:border-green-700 focus:ring ring-green-300 transition ease-in-out duration-150">
                            Tambah Prodi
                        </button>
                    </div>

                    <!-- Modal -->
                    <div x-show="open" style="display: none;" x-on:keydown.escape.window="open = false" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            
                            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="open = false" aria-hidden="true"></div>

                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                                <form id="dataprodiForm" action="{{ route('jurusan.dataprodi.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="dataprodi_id" id="dataprodi_id" value="{{ old('dataprodi_id') }}">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <h3 class="font-semibold text-lg mb-4" id="modal-title">Tambah Prodi Baru</h3>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="nama_prodi" class="block font-medium text-sm text-gray-700">Nama Prodi</label>
                                                <input type="text" name="nama_prodi" id="nama_prodi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('nama_prodi') }}" required>
                                                @error('nama_prodi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>

                                            <div>
                                                <label for="jenjang_pendidikan" class="block font-medium text-sm text-gray-700">Jenjang Pendidikan</label>
                                                <input type="text" name="jenjang_pendidikan" id="jenjang_pendidikan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('jenjang_pendidikan') }}" required>
                                                @error('jenjang_pendidikan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>

                                            <div>
                                                <label for="akronim_prodi" class="block font-medium text-sm text-gray-700">Akronim Prodi</label>
                                                <input type="text" name="akronim_prodi" id="akronim_prodi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('akronim_prodi') }}">
                                                @error('akronim_prodi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>                        
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-800 text-base font-medium text-white hover:bg-gray-700 sm:ml-3 sm:w-auto sm:text-sm">
                                            Simpan
                                        </button>
                                        <button type="button" @click="open = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <hr class="my-8">

                    <h3 class="font-semibold text-lg mb-4">Daftar Prodi</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Prodi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenjang Pendidikan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Akronim Prodi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($prodis as $prodi)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration + ($prodis->currentPage() - 1) * $prodis->perPage() }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $prodi->nama_prodi }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $prodi->jenjang_pendidikan ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $prodi->akronim_prodi  }}</td>
                
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-3">
                                            <button type="button" @click="
                                                open = true;
                                                let form = document.getElementById('dataprodiForm');
                                                let dpData = {{ Illuminate\Support\Js::from($prodi) }};
                                                form.action = '{{ url('jurusan/dataprodi') }}/' + dpData.id;

                                                if (!form.querySelector('input[name=_method]')) {
                                                    let methodInput = document.createElement('input');
                                                    methodInput.type = 'hidden';
                                                    methodInput.name = '_method';
                                                    methodInput.value = 'PUT';
                                                    form.appendChild(methodInput);
                                                } else {
                                                    form.querySelector('input[name=_method]').value = 'PUT';
                                                }

                                                document.getElementById('modal-title').innerText = 'Edit Data Prodi';
                                                form.querySelector('#nama_prodi').value = dpData.nama_prodi || '';
                                                form.querySelector('#jenjang_pendidikan').value = dpData.jenjang_pendidikan || '';
                                                form.querySelector('#akronim_prodi').value = dpData.akronim_prodi || '';
                                                form.querySelector('#dataprodi_id').value = dpData.id;
                                            " class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                                </svg>
                                            </button>

                                            <form action="{{ route('jurusan.dataprodi.destroy', $prodi->id) }}" method="POST" class="inline-block ml-4">
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
                                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                            Data belum tersedia.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $prodis->links() }}
                    </div>

                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>