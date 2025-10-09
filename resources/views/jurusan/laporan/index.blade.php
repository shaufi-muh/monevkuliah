<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Rekapitulasi Laporan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('jurusan.laporan.index') }}" method="GET">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label for="prodi_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Program Studi</label>
                                <select name="prodi_id" id="prodi_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="">Semua Prodi</option>
                                    @foreach($prodis as $prodi)
                                        <option value="{{ $prodi->id }}" {{ request('prodi_id') == $prodi->id ? 'selected' : '' }}>{{ $prodi->nama_prodi }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="tahun_akademik_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tahun Akademik</label>
                                <select name="tahun_akademik_id" id="tahun_akademik_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="">Semua Tahun</option>
                                    @foreach($tahunAkademiks as $tahun)
                                        <option value="{{ $tahun->id }}" {{ request('tahun_akademik_id') == $tahun->id ? 'selected' : '' }}>{{ $tahun->tahun_akademik }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="semester" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Semester</label>
                                <select name="semester" id="semester" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="">Semua Semester</option>
                                    <option value="Ganjil" {{ request('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                    <option value="Genap" {{ request('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                                </select>
                            </div>
                            <div>
                                <button type="submit" class="mt-6 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Tampilkan</button>
                            </div>
                        </div>
                    </form>

                    <div class="mt-8 space-y-8">
                        @if(request()->hasAny(['prodi_id', 'tahun_akademik_id', 'semester']))
                            @php
                                $hasData = false;
                                foreach ($reportData as $data) {
                                    if ($data['total_responden'] > 0) {
                                        $hasData = true;
                                        break;
                                    }
                                }
                            @endphp

                            @if($hasData)
                                @foreach($reportData as $data)
                                    @if($data['total_responden'] > 0)
                                        <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg shadow">
                                            <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200">{{ $data['isi_pertanyaan'] }}</h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Total Responden: {{ $data['total_responden'] }}</p>

                                            @if($data['tipe_jawaban'] == 'numerik' || $data['tipe_jawaban'] == 'boolean')
                                                <ul class="space-y-2">
                                                    @foreach($data['answers'] as $jawaban => $jumlah)
                                                        <li class="text-sm">
                                                            <div class="flex justify-between items-center">
                                                                <span class="text-gray-700 dark:text-gray-300">{{ $jawaban }}</span>
                                                                <span class="font-medium text-gray-900 dark:text-gray-100">{{ $jumlah }} suara</span>
                                                            </div>
                                                            @php
                                                                $percentage = ($data['total_responden'] > 0) ? ($jumlah / $data['total_responden']) * 100 : 0;
                                                            @endphp
                                                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 mt-1">
                                                                <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @elseif($data['tipe_jawaban'] == 'text')
                                                <ul class="list-disc list-inside space-y-2 mt-2">
                                                    @foreach($data['answers'] as $jawaban)
                                                        <li class="text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 p-2 rounded">{{ $jawaban }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <div class="text-center py-8">
                                    <p class="text-gray-500 dark:text-gray-400">Data tidak ditemukan untuk filter yang dipilih.</p>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500 dark:text-gray-400">Silakan pilih filter untuk menampilkan laporan.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
