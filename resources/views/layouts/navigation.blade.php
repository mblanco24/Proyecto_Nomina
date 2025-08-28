<nav x-data="{ open: false }" class="bg-blue-500 dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 ">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <!-- Logo Image -->
                        <x-application-logo class="" />
                    </a>
                </div>

                <!-- Navigation Links -->
                 @auth

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex ">
                    @if (auth()->user()->id_rol === 1)
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <div x-data="{ open: false }" class="relative ml-4">
                        <button @click="open = !open"
                            class="px-4 py-4 bg-blue-700 text-white rounded hover:bg-blue-800 focus:outline-none">
                            Personal de nomina

                        </button>
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white rounded shadow-lg z-50 py-2">
                            <a href="{{ route('employees.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100">Empleados</a>
                            <a href="{{ route('vacaciones.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100">Vacaciones</a>
                            <a href="{{ route('constancias.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100">Constancias de trabajo</a>

                        </div>
                    </div>
                    <div x-data="{ open: false }" class="relative ml-4">
                        <button @click="open = !open"
                            class="px-4 py-4 bg-blue-700 text-white rounded hover:bg-blue-800 focus:outline-none">
                            Pagos
                        </button>
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white rounded shadow-lg z-50 py-2">
                            <a href="{{ route('asignacion-metas.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100">Asignacion de metas</a>
                            <a href="{{ route('honorarios.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100">Reporte Biometrico</a>
                        </div>
                    </div>
                    <div x-data="{ open: false }" class="relative ml-4">
                        <button @click="open = !open"
                            class="px-4 py-4 bg-blue-700 text-white rounded hover:bg-blue-800 focus:outline-none">
                            Transporte
                        </button>
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white rounded shadow-lg z-50 py-2">
                            <a href="{{ route('registrotransporte.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100">Registro de transporte</a>
                        </div>
                    </div>


                    <div x-data="{ open: false }" class="relative ml-4">
                        <button @click="open = !open"
                            class="px-4 py-4 bg-blue-700 text-white rounded hover:bg-blue-800 focus:outline-none">
                            Personal de tecnologia
                        </button>
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white rounded shadow-lg z-50 py-1">
                            <a href="{{ route('users.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100">Usuarios</a>
                                                        <a href="{{ route('reportestecnologia.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100">Reporte de tecnoogia</a>

                        </div>
                    </div>
                    @elseif (auth()->user()->id_rol === 2)
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                        <div x-data="{ open: false }" class="relative ml-4">
                        <button @click="open = !open"
                            class="px-4 py-4 bg-blue-700 text-white rounded hover:bg-blue-800 focus:outline-none">
                            Personal de tecnologia
                        </button>
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white rounded shadow-lg z-50 py-1">
                            <a href="{{ route('users.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100">Usuarios</a>
                            <a href="{{ route('reportestecnologia.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100">Reporte de tecnoogia</a>

                        </div>
                    </div>
                    @elseif (auth()->user()->id_rol === 3)
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                        <div x-data="{ open: false }" class="relative ml-4">
                        <button @click="open = !open"
                            class="px-4 py-4 bg-blue-700 text-white rounded hover:bg-blue-800 focus:outline-none">
                            Personal de nomina
                        </button>
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white rounded shadow-lg z-50 py-2">
                            <a href="{{ route('employees.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100">Empleados</a>
                            <a href="{{ route('vacaciones.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100">Vacaciones</a>
                            <a href="{{ route('constancias.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100">Constancias de trabajo</a>
                        </div>
                    </div>
                    <div x-data="{ open: false }" class="relative ml-4">
                        <button @click="open = !open"
                            class="px-4 py-4 bg-blue-700 text-white rounded hover:bg-blue-800 focus:outline-none">
                            Pagos
                        </button>
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white rounded shadow-lg z-50 py-2">
                            <a href="{{ route('asignacion-metas.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100">Asignacion de metas</a>
                            <a href="{{ route('metas.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100">Pagos por metas</a>
                            <a href="{{ route('honorarios.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100">Reporte Biometrico</a>
                        </div>
                    </div>
                    <div x-data="{ open: false }" class="relative ml-4">
                        <button @click="open = !open"
                            class="px-4 py-4 bg-blue-700 text-white rounded hover:bg-blue-800 focus:outline-none">
                            Transporte
                        </button>
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white rounded shadow-lg z-50 py-2">
                            <a href="{{ route('registrotransporte.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100">Registro de transporte</a>
                        </div>
                    </div>
                @elseif (auth()->user()->id_rol === 4)
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                        <div x-data="{ open: false }" class="relative ml-4">


                    <div x-data="{ open: false }" class="relative ml-4">
                        <button @click="open = !open"
                            class="px-4 py-4 bg-blue-700 text-white rounded hover:bg-blue-800 focus:outline-none">
                            Transporte
                        </button>
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white rounded shadow-lg z-50 py-2">
                            <a href="{{ route('registrotransporte.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100">Registro de transporte</a>
                        </div>
                    </div>


                    @endif
                </div>
            </div>
            @endauth
            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link id="logout-link" :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Salir') }}
                            </x-dropdown-link>
                            <x-dropdown-link style="cursor: pointer;" id="change-password">
                                {{ __('Cambiar Contraseña') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden ">
        <div class="pt-2 pb-3 space-y-1 bg-blue-600">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t dark:border-gray-600">
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
                        {{ __('Salir') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/navigation.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const logoutLink = document.getElementById('logout-link');

        logoutLink.addEventListener('click', function (e) {
        localStorage.setItem('evento', 'salida')
    });
    });
</script>
