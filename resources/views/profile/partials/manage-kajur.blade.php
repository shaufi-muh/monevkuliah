<div class="space-y-4">
    <div>
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Kelola Ketua Jurusan') }}</h3>
        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Pilih dosen yang akan ditetapkan sebagai Ketua Jurusan. Nama dan NIP akan dipakai dalam laporan akhir.') }}</p>
    </div>

    <div class="mt-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('Pilih Ketua') }}</label>
        <div class="mt-1 relative">
            <template x-if="loadingDosens">
                <div class="text-sm text-gray-500">Memuat daftar dosen...</div>
            </template>

            <template x-if="!loadingDosens">
                <div>
                    <div class="flex items-center gap-2">
                        <input list="dosens-list" x-model="query" @input="onInputDosen($event)" placeholder="Ketik nama dosen..." class="flex-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />

                        <button type="button" @click="saveKetua()" class="inline-flex items-center px-3 py-2 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700">{{ __('Simpan') }}</button>
                    </div>

                    <input type="hidden" x-model="selectedKetua" />

                    <datalist id="dosens-list">
                        <template x-for="d in dosens" :key="d.id">
                            <option :value="d.nama_dosen + ' — ' + (d.nip || '-')"></option>
                        </template>
                    </datalist>
                </div>
            </template>
        </div>
    </div>

    <div class="mt-2">
        <template x-if="message">
            <div class="text-sm text-green-600" x-text="message"></div>
        </template>
    </div>
</div>
