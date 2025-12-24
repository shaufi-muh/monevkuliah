<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-bold mb-4">Periode Tahun Akademik</h3>
                            @if(isset($tahunAkademikAktif) && $tahunAkademikAktif)
                                <div class="bg-blue-50 border border-blue-200 rounded p-4 mb-4">
                                    <div class="flex items-center gap-3 text-xl font-semibold text-blue-800">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span>{{ $tahunAkademikAktif->tahun_akademik }} ({{ $tahunAkademikAktif->semester }})</span>
                                    </div>
                                    <div class="mt-2 text-sm text-gray-700">Status : <span class="font-bold text-green-600">Aktif</span></div>
                                </div>
                            @else
                                <div class="bg-red-50 border border-red-200 rounded p-4 mb-4">
                                    <span class="font-semibold text-red-600">Anda belum mengaktifkan tahun akademik.</span>
                                </div>
                            @endif
                        </div>

                        <div>
                            <h3 class="text-lg font-bold mb-4">Ketua Jurusan</h3>
                            @if(isset($ketua) && $ketua)
                                <div id="ketua-block" class="bg-white border border-gray-200 rounded p-4 mb-4">
                                    <div class="flex items-center gap-2 text-xl font-semibold text-gray-800">
                                        <svg class="w-5 h-5 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke="currentColor" >
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.386 0 4.633.563 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span id="ketua-nama">{{ $ketua->nama_dosen }}</span>
                                    </div>
                                    <div class="mt-2 text-sm text-gray-700 flex items-center gap-2"> 
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-600" >
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                                        </svg>
                                        <span>NIP : <span id="ketua-nip" class="font-semibold">{{ $ketua->nip }}</span></span>
                                    </div>
                                </div>
                                <div id="ketua-empty" class="hidden bg-yellow-50 border border-yellow-200 rounded p-4 mb-4">
                                    <span class="font-semibold text-yellow-700">Belum ada ketua jurusan yang dipilih.</span>
                                </div>
                            @else
                                <div id="ketua-block" class="hidden bg-white border border-gray-200 rounded p-4 mb-4">
                                    <div id="ketua-nama" class="text-xl font-semibold text-gray-800"></div>
                                    <div class="mt-2 text-sm text-gray-700">NIP: <span id="ketua-nip" class="font-semibold"></span></div>
                                </div>
                                <div id="ketua-empty" class="bg-yellow-50 border border-yellow-200 rounded p-4 mb-4">
                                    <span class="font-semibold text-yellow-700">Belum ada ketua jurusan yang dipilih.</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
