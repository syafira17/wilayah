<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-xl font-semibold">Admin Dashboard</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.dashboard') }}" 
                        class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md hover:bg-gray-100">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.petugas.index') }}" 
                        class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md hover:bg-gray-100">
                        Kelola Petugas
                    </a>
                    <a href="{{ route('admin.wilayah.index') }}" 
                        class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md hover:bg-gray-100">
                        Kelola Wilayah
                    </a>
                    <a href="{{ route('admin.login-history') }}" 
                        class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md hover:bg-gray-100">
                        Login History
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <h2 class="text-2xl font-bold mb-6">Selamat Datang, {{ Auth::user()->name }}</h2>

            <!-- Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Card Kelola Petugas -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Kelola Petugas</h3>
                                <div class="mt-2 space-y-2">
                                    <a href="{{ route('admin.petugas.index') }}" class="text-sm text-blue-500 hover:text-blue-700 block">
                                        → Lihat Daftar Petugas
                                    </a>
                                    <a href="{{ route('admin.petugas.create') }}" class="text-sm text-blue-500 hover:text-blue-700 block">
                                        → Tambah Petugas Baru
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Kelola Wilayah -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Kelola Wilayah</h3>
                                <div class="mt-2 space-y-2">
                                    <a href="{{ route('admin.wilayah.index') }}" class="text-sm text-green-500 hover:text-green-700 block">
                                        → Lihat Daftar Wilayah
                                    </a>
                                    <a href="{{ route('admin.wilayah.create') }}" class="text-sm text-green-500 hover:text-green-700 block">
                                        → Tambah Wilayah Baru
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Login History -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Login History</h3>
                                <a href="{{ route('admin.login-history') }}" class="mt-2 text-sm text-purple-500 hover:text-purple-700 block">
                                    → Lihat Riwayat Login
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tambahkan card baru untuk Statistik -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Statistik & Laporan</h3>
                                <a href="{{ route('admin.statistics') }}" class="mt-2 text-sm text-indigo-500 hover:text-indigo-700 block">
                                    → Lihat Statistik Wilayah
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <h4 class="text-lg font-semibold text-gray-700">Total Petugas</h4>
                    <p class="mt-2 text-3xl font-bold text-blue-600">
                        {{ App\Models\User::where('role', 'petugas')->count() }}
                    </p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <h4 class="text-lg font-semibold text-gray-700">Total Wilayah</h4>
                    <p class="mt-2 text-3xl font-bold text-green-600">
                        {{ App\Models\Wilayah::count() }}
                    </p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <h4 class="text-lg font-semibold text-gray-700">Login Hari Ini</h4>
                    <p class="mt-2 text-3xl font-bold text-purple-600">
                        {{ App\Models\LoginHistory::whereDate('login_at', today())->count() }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 