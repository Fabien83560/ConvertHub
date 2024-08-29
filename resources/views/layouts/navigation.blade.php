<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex items-center space-x-4">
                    <a href="/" class="flex items-center">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo" class="w-10 h-10">
                        <span class="text-3xl font-bold ml-2">ConvertHub</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-24 sm:flex">
                    <x-nav-link :href="url('/')" :active="request()->is('/')"> <!-- Change route -->
                        {{ __('Avalaible Conversion') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="url('/')" :active="request()->is('/')"> <!-- Change route -->
                        {{ __('API') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center">
                @auth
                    <x-dropdown class="sm:ms-4" align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

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
                @else
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">{{ __('Login') }}</a>
                        <a href="{{ route('register') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">{{ __('Register') }}</a>
                    </div>
                @endauth
                <div>
                    <form action="{{ route('set-language') }}" method="POST" class="relative inline-block">
                        @csrf
                        <div class="flex items-center cursor-pointer px-4 py-2 border border-gray-300 bg-gray-100 rounded-md select-selected">
                            <img src="{{ asset('img/flags/' . app()->getLocale() . '.png') }}" alt="Flag" class="w-6 h-4 mr-2">
                            {{ strtoupper(app()->getLocale()) }}
                        </div>
                        <div class="absolute right-0 mt-2 w-full bg-white border border-gray-300 rounded-md shadow-lg z-20 hidden select-items">
                            <div onclick="document.querySelector('input[name=locale][value=en]').click()" class="flex items-center px-4 py-2 cursor-pointer hover:bg-gray-100 text-gray-900 border-b border-gray-300">
                                <img src="{{ asset('img/flags/en.png') }}" alt="Flag" class="w-6 h-4 mr-2"> EN
                            </div>
                            <div onclick="document.querySelector('input[name=locale][value=fr]').click()" class="flex items-center px-4 py-2 cursor-pointer hover:bg-gray-100 text-gray-900 border-b border-gray-300">
                                <img src="{{ asset('img/flags/fr.png') }}" alt="Flag" class="w-6 h-4 mr-2"> FR
                            </div>
                        </div>
                        <input type="hidden" name="locale" value="{{ app()->getLocale() }}">
                    </form>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="url('/')" :active="request()->is('/')">
                <h1>Text To Change</h1>
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
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
            @else
                <div class="px-4">
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">{{ __('Login') }}</a>
                    <a href="{{ route('register') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">{{ __('Register') }}</a>
                </div>
            @endauth
        </div>
    </div>
</nav>
