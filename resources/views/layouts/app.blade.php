<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MONEV KULIAH') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">


        <!--<div class="min-h-screen bg-gray-100 flex"> div bawaan breeze-->
        <div x-data="{ open: false }" class="min-h-screen bg-gray-100 flex"> 
            <aside class="w-64 bg-white shadow-md fixed inset-y-0 left-0 z-30 transform transition-transform duration-300 ease-in-out pt-20" :class="open ? 'translate-x-0' : '-translate-x-full'" x-cloak>
                <!-- pt-20 to push below header (agar sidebar tidak tertutup header) -->
                @include('layouts.navigation')
            </aside>
            <div
                x-show="open"
                x-cloak
                @click="open = false"
                class="fixed inset-0 bg-black bg-opacity-50 z-20"
            ></div>

            <div class="flex-1 flex flex-col">

                    @if (isset($header))
                        <header class="bg-blue-800 shadow sticky top-0 z-50">

                            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                                <!-- Hamburger -->
                                <div class="-me-2 flex items-center">  <!--sm:hidden-->
                                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                            <!--    <h2  class="font-semibold text-xl text-gray-100 leading-tight" style="margin-left:-0.5rem;margin-right:-7.5rem">   
                                </h2> -->

                                <div class="font-semibold text-xl text-white leading-tight" style="margin-left:-0.5rem;margin-right:-7.5rem" >
                                    {{ $header }}
                                </div>

                                <!-- Settings Dropdown -->
                                <div class="hidden sm:flex sm:items-center sm:ms-6">
                                    <x-dropdown align="right" width="48">
                                        <x-slot name="trigger">
                                            
                                      <!--      <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"> -->
                                            <button class="inline-flex items-center text-sm leading-4 font-medium text-white dark:text-gray-300 hover:text-gray-300 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                                <div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                                                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z" />
                                                    </svg>
                                                </div>
                                                <div class="ms-1">
                                                    {{ Auth::user()->name }}
                                                </div>
                                                <div class="ms-1">
                                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </button>
                                        </x-slot>

                                        <x-slot name="content">
                                                <a href="#" @click.prevent="$dispatch('open-modal', 'profile-modal')" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-100">{{ __('Profile') }}</a>

                                            <!-- Authentication -->
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf

                                                <x-dropdown-link :href="route('logout')"
                                                        onclick="event.preventDefault();
                                                                    this.closest('form').submit();">
                                                    {{ __('Log Out') }}
                                                </x-dropdown-link>
                                            </form>
                                        </x-slot>
                                    </x-dropdown>
                                </div>


                            </div>
                        </header>
                    @endif

                    <main>
                        {{ $slot }}
                    </main>
                </div>
            </div>  
      
      {{--
            <!--bawaan laravel, menu horizontal di atas kesamping -->
      <!--  <div class="min-h-screen bg-gray-100 dark:bg-gray-900"> -->
        <!--    @include('layouts.navigation') --> 
        <!--
             Page Heading 
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset


            Page Content -->
            
            <main>
                {{ $slot }}
            </main>
            --}}
            <!-- Profile modal (tabs) -->
            <x-modal name="profile-modal" maxWidth="lg" focusable>
                <div class="p-4">
                    <div x-data="profileModal()" class="w-full h-96 flex flex-col">
                        <div class="flex items-center gap-6 border-b pb-3">
                            <button type="button" @click="tab='info'" :class="tab==='info' ? 'bg-indigo-50 text-indigo-700 px-4 py-2 rounded-md shadow-sm' : 'text-gray-600 dark:text-gray-200 px-4 py-2 rounded-md'"> 
                                <svg class="inline w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.386 0 4.633.563 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ __('Profile') }}
                            </button>

                            <button type="button" @click="(tab='ketua', loadDosens())" :class="tab==='ketua' ? 'bg-indigo-50 text-indigo-700 px-4 py-2 rounded-md shadow-sm' : 'text-gray-600 dark:text-gray-200 px-4 py-2 rounded-md'">
                                <svg class="inline w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7 7h.01M7 11h.01M7 15h.01"/></svg>
                                {{ __('Ketua Jurusan') }}
                            </button>

                            <button type="button" @click="tab='password'" :class="tab==='password' ? 'bg-indigo-50 text-indigo-700 px-4 py-2 rounded-md shadow-sm' : 'text-gray-600 dark:text-gray-200 px-4 py-2 rounded-md'">
                                <svg class="inline w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3z"/></svg>
                                {{ __('Password') }}
                            </button>

                            
                            <!-- delete tab disabled; removed per request -->
                        </div>

                        <div class="flex-1 overflow-auto mt-4">
                            <div x-show="tab==='info'" x-cloak>
                                @include('profile.partials.update-profile-information-form', ['user' => Auth::user()])
                            </div>

                            <div x-show="tab==='password'" x-cloak>
                                @include('profile.partials.update-password-form')
                            </div>

                            <div x-show="tab==='ketua'" x-cloak class="px-2">
                                @include('profile.partials.manage-kajur')
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function profileModal() {
                        return {
                            tab: 'info',
                            dosens: [],
                            loadingDosens: false,
                            selectedKetua: null,
                            message: null,
                            query: '',
                            dropdownOpen: false,
                            loadDosens() {
                                if (this.dosens.length) return;
                                this.loadingDosens = true;
                                const url = '{{ url('/jurusan/dosens') }}';
                                fetch(url, { credentials: 'same-origin' })
                                    .then(r => r.json())
                                    .then(resp => { this.dosens = resp.data || []; if (resp.current_ketua_id) this.selectedKetua = resp.current_ketua_id; })
                                    .catch(() => {})
                                    .finally(() => this.loadingDosens = false);
                            },
                            filteredDosens() {
                                if (!this.query) return this.dosens;
                                return this.dosens.filter(d => (d.nama_dosen || '').toLowerCase().includes(this.query.toLowerCase()));
                            },
                            openDropdown() { this.dropdownOpen = true; },
                            closeDropdown() { this.dropdownOpen = false; },
                            chooseDosen(id) { this.selectedKetua = id; this.dropdownOpen = false; this.query = this.dosens.find(d => d.id == id)?.nama_dosen || ''; },
                            onInputDosen(e) {
                                const val = e.target.value || '';
                                this.query = val;
                                const needle = (val || '').toString();
                                const match = this.dosens.find(d => (d.nama_dosen + ' — ' + (d.nip || '-')) === needle);
                                if (match) {
                                    this.selectedKetua = match.id;
                                } else {
                                    this.selectedKetua = null;
                                }
                            },
                            saveKetua() {
                                this.message = null;
                                const url = '{{ url('/jurusan/ketua') }}';
                                fetch(url, {
                                    method: 'POST',
                                    credentials: 'same-origin',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                    },
                                    body: JSON.stringify({ dosen_id: this.selectedKetua })
                                })
                                .then(r => {
                                    if (!r.ok) {
                                        return r.text().then(t => { throw new Error(t || ('HTTP ' + r.status)); });
                                    }
                                    return r.json();
                                })
                                .then(js => {
                                      this.message = js.message || 'Sukses';
                                      // Update dashboard DOM if present
                                      try {
                                          const ketua = js.ketua || null;
                                          const block = document.getElementById('ketua-block');
                                          const empty = document.getElementById('ketua-empty');
                                          if (ketua && block) {
                                              const nameEl = document.getElementById('ketua-nama');
                                              const nipEl = document.getElementById('ketua-nip');
                                              if (nameEl) nameEl.textContent = ketua.nama_dosen || '';
                                              if (nipEl) nipEl.textContent = ketua.nip || '';
                                              if (block.classList.contains('hidden')) block.classList.remove('hidden');
                                              if (empty && !empty.classList.contains('hidden')) empty.classList.add('hidden');
                                          } else if (block && empty) {
                                              // no ketua selected -> show empty
                                              if (!block.classList.contains('hidden')) block.classList.add('hidden');
                                              if (empty.classList.contains('hidden')) empty.classList.remove('hidden');
                                          }
                                      } catch (e) {
                                          // ignore DOM update errors
                                      }
                                  })
                                  .catch((err) => { console.error('saveKetua error:', err); this.message = 'Terjadi kesalahan' + (err?.message ? ': ' + err.message : ''); });
                            }
                        };
                    }
                </script>
            </x-modal>

        </div>
    </body>
</html>
