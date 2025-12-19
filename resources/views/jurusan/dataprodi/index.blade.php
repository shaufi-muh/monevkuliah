<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Kelola Data Prodi') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{
    open: @json($errors->hasAny(['nama_prodi','jenjang_pendidikan','akronim_prodi'])),
    userModal: false,
    createUserModal: false,
    editUserModal: false,
    deleteConfirmModal: false,
    selectedProdi: null,
    editUser: { id: null, name: '', email: '' },
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
                    <!-- Delete confirm modal -->
                    <div x-show="deleteConfirmModal" x-cloak style="display:none;" x-on:keydown.escape.window="deleteConfirmModal = false" class="fixed z-40 inset-0 overflow-y-auto" aria-labelledby="delete-confirm-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div x-show="deleteConfirmModal" x-transition class="fixed inset-0 bg-gray-500 bg-opacity-75" @click="deleteConfirmModal = false"></div>
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                            <div x-show="deleteConfirmModal" x-transition class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <h3 class="font-semibold text-lg mb-2" id="delete-confirm-title">Hapus Prodi <span class="font-normal" x-text="selectedProdi ? (' - ' + selectedProdi.nama_prodi) : ''"></span></h3>
                                    <p class="text-sm text-gray-700 mb-4">Aksi ini akan menghapus data Prodi. Terdapat data terkait:</p>
                                    <ul class="text-sm text-gray-700 space-y-1">
                                        <li x-show="selectedProdi && selectedProdi.dosens_count"><strong x-text="selectedProdi.dosens_count"></strong> Dosen</li>
                                        <li x-show="selectedProdi && selectedProdi.users_count"><strong x-text="selectedProdi.users_count"></strong> User</li>
                                        <li x-show="selectedProdi && selectedProdi.kelas_count"><strong x-text="selectedProdi.kelas_count"></strong> Kelas</li>
                                        <li x-show="selectedProdi && selectedProdi.mahasiswas_count"><strong x-text="selectedProdi.mahasiswas_count"></strong> Mahasiswa</li>
                                    </ul>
                                    <p class="text-sm text-red-600 mt-3">Pastikan Anda sudah membackup data jika ingin melanjutkan. Pilih tindakan:</p>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <form x-bind:action="'{{ url('jurusan/dataprodi') }}/' + (selectedProdi ? selectedProdi.id : '') + '/force-delete'" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-500 sm:ml-3 sm:w-auto sm:text-sm">Hapus beserta data terkait</button>
                                    </form>
                                    <button type="button" @click="deleteConfirmModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Edit User (inline) -->
                    <div x-show="editUserModal" x-cloak style="display: none;" x-on:keydown.escape.window="editUserModal = false" class="fixed z-30 inset-0 overflow-y-auto" aria-labelledby="edit-user-modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div x-show="editUserModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="editUserModal = false" aria-hidden="true"></div>
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                            <div x-show="editUserModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                <form x-bind:action="'{{ url('jurusan/userprodi') }}/' + editUser.id" method="POST">
                                    @csrf
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="user_id" x-model="editUser.id">
                                    <input type="hidden" name="prodi_id" x-bind:value="selectedProdi ? selectedProdi.id : ''">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <h3 class="font-semibold text-lg mb-2" id="edit-user-modal-title">Edit User untuk <span x-text="selectedProdi ? selectedProdi.nama_prodi : ''"></span></h3>
                                        <p class="text-sm text-gray-600 mb-4">Perbarui data user. Kosongkan password jika tidak ingin mengubah.</p>

                                        <div class="grid grid-cols-1 gap-3">
                                            <div>
                                                <label for="edit_name" class="block text-sm font-medium text-gray-700">Nama User</label>
                                                <input id="edit_name" name="name" type="text" x-model="editUser.name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            </div>

                                            <div>
                                                <label for="edit_email" class="block text-sm font-medium text-gray-700">Email</label>
                                                <input id="edit_email" name="email" type="email" x-model="editUser.email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            </div>

                                            <div>
                                                <label for="edit_password" class="block text-sm font-medium text-gray-700">Password (kosong = tidak diubah)</label>
                                                <input id="edit_password" name="password" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            </div>

                                            <div>
                                                <label for="edit_password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                                                <input id="edit_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">Simpan</button>
                                        <button type="button" @click="editUserModal = false; userModal = true" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal untuk Kelola User per Prodi -->
                    <div x-show="userModal" style="display: none;" x-on:keydown.escape.window="userModal = false" class="fixed z-20 inset-0 overflow-y-auto" aria-labelledby="user-modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div x-show="userModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="userModal = false" aria-hidden="true"></div>
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                            <div x-show="userModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <h3 class="font-semibold text-lg mb-2" id="user-modal-title">Kelola User untuk <span x-text="selectedProdi ? selectedProdi.nama_prodi : ''"></span></h3>
                                    <p class="text-sm text-gray-600 mb-4">Pilih tindakan yang ingin dilakukan untuk program studi ini.</p>

                                    <!-- Jika belum ada user untuk prodi ini -->
                                    <div x-show="!(selectedProdi && selectedProdi.users)">
                                        <p class="text-sm text-gray-700 mb-4">Program studi ini belum memiliki user untuk login. Silakan tambahkan user agar dapat mengakses sistem.</p>
                                        <div class="flex justify-center mt-6">
                                            <button type="button" @click="userModal = false; createUserModal = true;" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md">Tambah User</button>
                                        </div>
                                    </div>

                                    <!-- Jika sudah ada user -->
                                    <div x-show="selectedProdi && selectedProdi.users" class="space-y-3">
                                        <p class="text-sm text-gray-700">Program studi ini sudah memiliki user.</p>
                                        <div class="bg-gray-50 p-3 rounded border">
                                            <div class="text-sm text-gray-800">Nama User: <strong x-text="selectedProdi.users.name"></strong></div>
                                            <div class="text-sm text-gray-800">Email: <strong x-text="selectedProdi.users.email"></strong></div>
                                        </div>
                                            <div class="flex gap-4 justify-center mt-6">
                                                <button type="button" @click="editUser.id = selectedProdi.users.id; editUser.name = selectedProdi.users.name; editUser.email = selectedProdi.users.email; userModal = false; editUserModal = true;" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md">Edit User</button>
                                                <form x-show="selectedProdi && selectedProdi.users" x-bind:action="'{{ url('jurusan/userprodi') }}/' + selectedProdi.users.id" method="POST" onsubmit="return confirm('Hapus user ini? Aksi tidak dapat dibatalkan.');">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md">Hapus User</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="button" @click="userModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Tutup</button>
                                </div>
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status User</th>
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
                
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="flex items-center gap-2">
                                                <button type="button" @click="userModal = true; selectedProdi = {{ Illuminate\Support\Js::from($prodi) }};" class="text-gray-600 hover:text-gray-900" title="Kelola User">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 20" fill="currentColor" class="w-5 h-5">
                                                        <path d="M5.25 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0Zm0 8.25a6.375 6.375 0 0 1 12.75 0v.187a.75.75 0 0 1-.364.63 11.817 11.817 0 0 1-5.999 1.661 11.817 11.817 0 0 1-5.999-1.661.75.75 0 0 1-.388-.63V14.625Z" />
                                                    </svg>
                                                </button>
                                                @if($prodi->users)
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Aktif</span>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">Tidak Aktif</span>
                                                @endif
                                            </div>
                                        </td>

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

                                            

                                            <button type="button" @click="selectedProdi = {{ \Illuminate\Support\Js::from([
                                                'id' => $prodi->id,
                                                'nama_prodi' => $prodi->nama_prodi,
                                                'dosens_count' => $prodi->dosens()->count(),
                                                'users_count' => $prodi->users()->count(),
                                                'kelas_count' => \App\Models\Kelas::where('prodi_id', $prodi->id)->count(),
                                                'mahasiswas_count' => $prodi->mahasiswas()->count(),
                                            ]) }}; deleteConfirmModal = true;" class="inline-block ml-4 text-red-600 hover:text-red-900" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.134-2.09-2.134H8.09c-1.18 0-2.09.954-2.09 2.134v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
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
                    <!-- Modal Create User (inline) -->
                    <div x-show="createUserModal" x-cloak style="display: none;" x-on:keydown.escape.window="createUserModal = false" class="fixed z-30 inset-0 overflow-y-auto" aria-labelledby="create-user-modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div x-show="createUserModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="createUserModal = false" aria-hidden="true"></div>
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                            <div x-show="createUserModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                <form action="{{ route('jurusan.userprodi.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="prodi_id" x-bind:value="selectedProdi ? selectedProdi.id : ''">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <h3 class="font-semibold text-lg mb-2" id="create-user-modal-title">Tambah User untuk <span x-text="selectedProdi ? selectedProdi.nama_prodi : ''"></span></h3>
                                        <p class="text-sm text-gray-600 mb-4">Isi data user agar prodi dapat login.</p>

                                        <div class="grid grid-cols-1 gap-3">
                                            <div>
                                                <label for="name_create" class="block text-sm font-medium text-gray-700">Nama User</label>
                                                <input id="name_create" name="name" type="text" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('name') }}">
                                                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>

                                            <div>
                                                <label for="email_create" class="block text-sm font-medium text-gray-700">Email</label>
                                                <input id="email_create" name="email" type="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('email') }}">
                                                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>

                                            <div>
                                                <label for="password_create" class="block text-sm font-medium text-gray-700">Password</label>
                                                <input id="password_create" name="password" type="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                                @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>

                                            <div>
                                                <label for="password_confirmation_create" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                                                <input id="password_confirmation_create" name="password_confirmation" type="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-500 sm:ml-3 sm:w-auto sm:text-sm">Simpan</button>
                                        <button type="button" @click="createUserModal = false; userModal = true" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
</x-app-layout>