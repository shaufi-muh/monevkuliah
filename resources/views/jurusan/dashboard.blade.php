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
                    <h3 class="text-lg font-bold mb-4">Periode Tahun Akademik</h3>
                    @if(isset($tahunAkademikAktif) && $tahunAkademikAktif)
                        <div class="bg-blue-50 border border-blue-200 rounded p-4 mb-4">
                            <div class="text-xl font-semibold text-blue-800">{{ $tahunAkademikAktif->tahun_akademik }} ({{ $tahunAkademikAktif->semester }})</div>
                            <div class="mt-2 text-sm text-gray-700">Status: <span class="font-bold text-green-600">Aktif</span></div>
                        </div>
                    @else
                        <div class="bg-red-50 border border-red-200 rounded p-4 mb-4">
                            <span class="font-semibold text-red-600">Anda belum mengaktifkan tahun akademik.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
