<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Kelola Data Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{
    open: @json($errors->any()),
        initForm() {
            const form = document.getElementById('mahasiswaForm');
            const mhsIdInput = form.querySelector('#mahasiswa_id');
            const mhsId = mhsIdInput ? mhsIdInput.value : '';
            if (this.open && mhsId) {
                document.getElementById('modal-title').innerText = 'Edit Mahasiswa';
                form.action = '{{ url('prodi/mahasiswa') }}/' + mhsId;
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

            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Oops! Terjadi kesalahan.</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <button @click="
                            open = true;
                            let form = document.getElementById('mahasiswaForm');
                            form.action = '{{ route('prodi.mahasiswa.store') }}';
                            if (form.querySelector('input[name=_method]')) {
                                form.querySelector('input[name=_method]').remove();
                            }
                            form.reset();
                            document.getElementById('modal-title').innerText = 'Tambah Mahasiswa Baru';
                            if (form.querySelector('#mahasiswa_id')) form.querySelector('#mahasiswa_id').value = '';
                        " class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:border-green-700 focus:ring ring-green-300 transition ease-in-out duration-150">
                            Tambah Mahasiswa
                        </button>
                    </div>

                    <!-- Modal -->
                    <div x-show="open" style="display: none;" x-on:keydown.escape.window="open = false" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            
                            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="open = false" aria-hidden="true"></div>

                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                                <form id="mahasiswaForm" action="{{ route('prodi.mahasiswa.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="mahasiswa_id" id="mahasiswa_id" value="{{ old('mahasiswa_id') }}">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <h3 class="font-semibold text-lg mb-4" id="modal-title">Tambah Mahasiswa Baru</h3>
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                            <div>
                                                <label for="nim" class="block font-medium text-sm text-gray-700">NIM</label>
                                                <input type="text" name="nim" id="nim" value="{{ old('nim') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                                @error('nim') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>
                                            <div>
                                                <label for="nama" class="block font-medium text-sm text-gray-700">Nama Lengkap</label>
                                                <input type="text" name="nama" id="nama" value="{{ old('nama') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                                @error('nama') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>
                                            <div>
                                                <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                                                <input type="email" name="email" id="email" value="{{ old('email') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>
                                            <div>
                                                <label for="no_telp" class="block font-medium text-sm text-gray-700">No. Telepon</label>
                                                <input type="text" name="no_telp" id="no_telp" value="{{ old('no_telp') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                                @error('no_telp') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>
                                            <div>
                                                <label for="status_mahasiswa" class="block font-medium text-sm text-gray-700">Status Mahasiswa</label>
                                                <select name="status_mahasiswa" id="status_mahasiswa" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                                    <option value="Aktif" {{ old('status_mahasiswa') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                    <option value="Cuti" {{ old('status_mahasiswa') == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                                                    <option value="Non-Aktif" {{ old('status_mahasiswa') == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                                                </select>
                                                @error('status_mahasiswa') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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

                    <h3 class="font-semibold text-lg mb-4">Daftar Mahasiswa</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIM</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Telp. / Hp</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($mahasiswas as $mhs)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration + ($mahasiswas->currentPage() - 1) * $mahasiswas->perPage() }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $mhs->nim }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $mhs->nama }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $mhs->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $mhs->no_telp }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $tahunAkademikAktif = \App\Models\TahunAkademik::where('status', 'aktif')->first();
                                                $pivot = $tahunAkademikAktif ? $mhs->mahasiswaSemesters->where('tahun_akademik_id', $tahunAkademikAktif->id)->first() : null;
                                            @endphp
                                            @if($pivot)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $pivot->status_mahasiswa == 'Aktif' ? 'bg-green-100 text-green-800' : ($pivot->status_mahasiswa == 'Cuti' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                    {{ $pivot->status_mahasiswa }}
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Tidak Ada Data</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-3">
                                            <button type="button" @click="
                                                open = true;
                                                let form = document.getElementById('mahasiswaForm');
                                                let mhsData = {{ Illuminate\Support\Js::from($mhs) }};
                                                form.action = '{{ url('prodi/mahasiswa') }}/' + mhsData.id;

                                                if (!form.querySelector('input[name=_method]')) {
                                                    let methodInput = document.createElement('input');
                                                    methodInput.type = 'hidden';
                                                    methodInput.name = '_method';
                                                    methodInput.value = 'PUT';
                                                    form.appendChild(methodInput);
                                                } else {
                                                    form.querySelector('input[name=_method]').value = 'PUT';
                                                }

                                                if (form.querySelector('#mahasiswa_id')) form.querySelector('#mahasiswa_id').value = mhsData.id;
                                                form.querySelector('#nim').value = mhsData.nim || '';
                                                form.querySelector('#nama').value = mhsData.nama || '';
                                                form.querySelector('#email').value = mhsData.email || '';
                                                form.querySelector('#no_telp').value = mhsData.no_telp || '';
                                                form.querySelector('#status_mahasiswa').value = (mhsData.status_mahasiswa ?? (mhsData.mahasiswaSemesters && mhsData.mahasiswaSemesters.length ? mhsData.mahasiswaSemesters[0].status_mahasiswa : '')) || '';
                                                document.getElementById('modal-title').innerText = 'Edit Mahasiswa';
                                            " class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                                </svg>
                                            </button>
                                            <form action="{{ route('prodi.mahasiswa.destroy', $mhs->id) }}" method="POST" class="inline-block ml-4">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Anda yakin ingin menghapus data ini?')">
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
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                            Data belum tersedia.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $mahasiswas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>