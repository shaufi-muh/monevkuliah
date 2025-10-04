<x-guest-layout>
    <div class="py-8 sm:py-12">
        <div class="w-full mx-auto px-2 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-lg mx-auto" style="max-width:100vw;">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="font-semibold text-2xl text-gray-800 leading-tight mb-4 text-center">
                        Formulir Evaluasi Perkuliahan
                    </h2>
                    <p class="mb-2 text-center">Nama Mahasiswa: <strong>{{ $mahasiswa->nama }}</strong></p>
                    <p class="mb-6 text-center">Silakan isi evaluasi untuk setiap mata kuliah di bawah ini.</p>
                    <form action="{{ route('evaluasi.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="token" value="{{ $evaluasiToken->token }}">
                        <div class="overflow-x-auto">
                            <table class="w-full divide-y divide-gray-200 border text-xs sm:text-sm" style="min-width:900px;">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-2 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-500 uppercase border-r">Mata Kuliah</th>
                                        <th class="px-2 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-500 uppercase border-r">Dosen</th>
                                        @foreach ($pertanyaans as $pertanyaan)
                                            <th class="px-2 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-500 uppercase border-r">{{ $pertanyaan->isi_pertanyaan }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($mataKuliahs as $mk)
                                        @foreach ($mk->mataKuliahs as $matkul)
                                            <tr class="border-b border-gray-200">
                                                <td class="px-2 py-2 sm:px-4 sm:py-3 border-r align-top bg-gray-50">
                                                    <span class="block font-semibold text-gray-700">{{ $matkul->nama_matkul }}</span>
                                                </td>
                                                <td class="px-2 py-2 sm:px-4 sm:py-3 border-r align-top">
                                                    @foreach ($matkul->dosenPengampu as $dosen)
                                                        <span class="block text-gray-600">{{ $dosen->nama_dosen }}</span>
                                                    @endforeach
                                                </td>
                                                @foreach ($pertanyaans as $pertanyaan)
                                                    <td class="px-2 py-2 sm:px-4 sm:py-3 border-r align-top">
                                                        @if ($pertanyaan->tipe_jawaban == 'numerik')
                                                            <input type="number" name="jawaban[{{ $mk->id }}][{{ $matkul->id }}][{{ $pertanyaan->id }}]" class="w-full sm:w-24 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-xs sm:text-sm" required>
                                                        @elseif ($pertanyaan->tipe_jawaban == 'boolean')
                                                            <select name="jawaban[{{ $mk->id }}][{{ $matkul->id }}][{{ $pertanyaan->id }}]" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-xs sm:text-sm" required>
                                                                <option value="">-- Pilih --</option>
                                                                <option value="1">Ada / Sesuai</option>
                                                                <option value="0">Tidak Ada / Tidak Sesuai</option>
                                                            </select>
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    @empty
                                        <tr>
                                            <td colspan="{{ 2 + $pertanyaans->count() }}" class="text-center py-4 text-gray-500">
                                                Tidak ada data mata kuliah yang perlu dievaluasi.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="flex items-center justify-center mt-6">
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs sm:text-sm text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">Kirim Jawaban Evaluasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>