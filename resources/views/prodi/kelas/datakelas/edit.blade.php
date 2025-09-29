<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Edit Kelas: ') }} {{ $kelas->nama_kelas }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('prodi.datakelas.update', $kelas->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <div>
                            <label for="urutan_semester">Semester Ke-</label>
                            <select name="urutan_semester" id="urutan_semester" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                @for ($i = 1; $i <= 14; $i++)
                                <option value="{{ $i }}" @selected(old('urutan_semester', $kelas->urutan_semester) == $i)>
                                    {{ $i }}
                                </option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label for="grup_kelas">Grup</label>
                            <input type="text" name="grup_kelas" id="grup_kelas" maxlength="1" value="{{ old('grup_kelas', $kelas->grup_kelas) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required style="text-transform:uppercase">
                        </div>
                        <div>
                            <label>Nama Kelas (Otomatis)</label>
                            <p id="preview_nama_kelas" class="mt-2 text-lg font-bold text-gray-600">{{ $kelas->nama_kelas }}</p>
                        </div>
                    </div>
                    @error('nama_kelas') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    <div class="mt-4 flex items-center gap-4">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border rounded-md font-semibold text-xs text-white uppercase hover:bg-gray-700">
                            Update
                        </button>
                        <a href="{{ route('prodi.datakelas.index') }}" class="text-gray-600 hover:underline">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <script>
        // Script sederhana untuk preview nama kelas
        const tahun = document.getElementById('urutan_semester');
        const grup = document.getElementById('grup_kelas');
        const preview = document.getElementById('preview_nama_kelas');
        const akronim = '{{ Auth::user()->prodi->akronim_prodi }}';

        function updatePreview() {
            preview.textContent = `${akronim}-${tahun.value}${grup.value.toUpperCase()}`;
        }
        tahun.addEventListener('change', updatePreview);
        grup.addEventListener('keyup', updatePreview);
    </script>
</x-app-layout>