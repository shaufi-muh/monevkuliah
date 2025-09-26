<x-guest-layout> {{-- Atau layout lain yang sesuai untuk mahasiswa --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="font-semibold text-2xl text-gray-800 leading-tight mb-4">
                        Formulir Evaluasi Perkuliahan
                    </h2>
                    
                    <p class="mb-2">Nama Mahasiswa: <strong>{{ $mahasiswa->name }}</strong></p>
                    <p class="mb-6">Silakan isi evaluasi untuk setiap mata kuliah di bawah ini.</p>
                    
                    <form action="{{ route('evaluasi.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $evaluasiToken->token }}">
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 border">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left ... border-r">Mata Kuliah</th>
                                        <th class="px-4 py-3 text-left ... border-r">Dosen</th>
                                        
                                        {{-- Header Kolom Pertanyaan Dibuat Dinamis --}}
                                        @foreach ($pertanyaans as $pertanyaan)
                                            <th class="px-4 py-3 text-left ... border-r">{{ $pertanyaan->isi_pertanyaan }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($mataKuliahs as $mk)
                                        <tr>
                                            <td class="px-4 py-3 border-r">{{ $mk->nama_matkul }}</td>
                                            <td class="px-4 py-3 border-r">{{ $mk->dosen->name }}</td>
                                            
                                            {{-- Input Jawaban Dibuat Dinamis --}}
                                            @foreach ($pertanyaans as $pertanyaan)
                                                <td class="px-4 py-3 border-r">
                                                    {{-- KUNCI: name dibuat menjadi array agar mudah diproses --}}
                                                    @if ($pertanyaan->tipe_jawaban == 'numerik')
                                                        <input type="number" name="jawaban[{{ $mk->id }}][{{ $pertanyaan->id }}]" class="w-24 border-gray-300 ... rounded-md" required>
                                                    @elseif ($pertanyaan->tipe_jawaban == 'boolean')
                                                        <select name="jawaban[{{ $mk->id }}][{{ $pertanyaan->id }}]" class="w-full border-gray-300 ... rounded-md" required>
                                                            <option value="">-- Pilih --</option>
                                                            <option value="1">Ada / Sesuai</option>
                                                            <option value="0">Tidak Ada / Tidak Sesuai</option>
                                                        </select>
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Kirim Jawaban Evaluasi') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>