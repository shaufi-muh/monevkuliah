<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                </div> -->
                <!-- Navigation Links BUATAN -->
                
                <!--    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex"> bawaan laravel breeze horizontal -->
                <div class="flex flex-col space-y-4 p-4 h-full">
                    <div>
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    </div>
                    @if(auth()->user()->role === 'prodi')
                    <div class="border-gray-200 dark:border-gray-700"></div>
                        <div class="space-y-2">
                            <h6 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Manajemen Data
                            </h6>


                            <x-nav-link :href="route('prodi.dosen.index')" :active="request()->routeIs('prodi.dosen*')">
                                {{ __('Kelola Dosen') }}
                            </x-nav-link>
                            <x-nav-link :href="route('prodi.matakuliah.index')" :active="request()->routeIs('prodi.matakuliah*')">
                                {{ __('Mata Kuliah') }}
                            </x-nav-link>
                        </div>
                    </div>
                </div>
                @endif      
            <!-- dropdown profil awalnya di sini sebelum dipindah ke app.blade.php -->

            
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
