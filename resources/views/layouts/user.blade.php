<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Sistem Informasi Wilayah')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @yield('styles')
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <!-- Logo dan Nama Aplikasi -->
                <div class="flex items-center">
                    <a href="{{ route('wilayah.index') }}" class="flex items-center space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                        <span class="text-xl font-bold text-white">
                            Sistem Informasi Wilayah
                        </span>
                    </a>
                </div>

                <!-- User Menu -->
                <div class="flex items-center">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex items-center space-x-3 text-white hover:bg-blue-700 px-4 py-2 rounded-lg transition duration-150 ease-in-out">
                            <img src="{{ auth()->user()->avatar_url }}" 
                                 alt="Profile" 
                                 class="h-8 w-8 rounded-full object-cover ring-2 ring-white">
                            <div class="flex flex-col items-start">
                                <span class="text-sm font-semibold">{{ auth()->user()->name }}</span>
                                <span class="text-xs opacity-75">{{ ucfirst(auth()->user()->role) }}</span>
                            </div>
                            <!-- Dropdown Arrow -->
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                 class="h-5 w-5 transition-transform duration-200" 
                                 :class="{ 'transform rotate-180': open }"
                                 viewBox="0 0 20 20" 
                                 fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-1 ring-1 ring-black ring-opacity-5">
                            <a href="{{ route('profile.show') }}" 
                               class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                     class="h-5 w-5 mr-3 text-gray-400 group-hover:text-blue-500" 
                                     viewBox="0 0 20 20" 
                                     fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                                Profil Saya
                            </a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="group flex w-full items-center px-4 py-2 text-sm text-red-700 hover:bg-red-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                         class="h-5 w-5 mr-3 text-red-400 group-hover:text-red-500" 
                                         viewBox="0 0 20 20" 
                                         fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    @yield('scripts')
</body>
</html> 