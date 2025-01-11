@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Alert Section -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Sidebar Menu -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-lg font-semibold mb-4">Menu Petugas</h2>
                <nav class="space-y-2">
                    <a href="{{ route('petugas.dashboard') }}" 
                       class="block px-4 py-2 rounded-md hover:bg-indigo-50 text-indigo-600">
                        Dashboard
                    </a>
                    <a href="{{ route('petugas.penduduk.index') }}" 
                       class="block px-4 py-2 rounded-md hover:bg-indigo-50">
                        Data Penduduk
                    </a>
                    <a href="{{ route('petugas.laporan.index') }}" 
                       class="block px-4 py-2 rounded-md hover:bg-indigo-50">
                        Laporan
                    </a>
                    <a href="{{ route('petugas.dokumen.index') }}" 
                       class="block px-4 py-2 rounded-md hover:bg-indigo-50">
                        Dokumen
                    </a>
                    <a href="{{ route('petugas.wilayah.edit') }}" 
                       class="block px-4 py-2 rounded-md hover:bg-indigo-50">
                        Update Wilayah
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="lg:col-span-3">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h1 class="text-2xl font-bold mb-6">Dashboard Petugas</h1>

                @if(!auth()->user()->wilayah_id)
                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4">
                        <strong>Perhatian!</strong> Anda belum ditugaskan ke wilayah manapun.
                    </div>
                @else
                    <!-- Statistik Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-blue-50 p-6 rounded-lg">
                            <h3 class="font-bold text-lg mb-2">Wilayah Tugas</h3>
                            <p class="text-gray-600">{{ $wilayah->nama_wilayah }}</p>
                            <p class="text-gray-600">Kode: {{ $wilayah->kode_wilayah }}</p>
                        </div>

                        <div class="bg-green-50 p-6 rounded-lg">
                            <h3 class="font-bold text-lg mb-2">Total Penduduk</h3>
                            <p class="text-3xl font-bold text-green-600">{{ number_format($totalPenduduk) }}</p>
                        </div>

                        <div class="bg-purple-50 p-6 rounded-lg">
                            <h3 class="font-bold text-lg mb-2">Luas Wilayah</h3>
                            <p class="text-3xl font-bold text-purple-600">{{ number_format($luasWilayah, 2) }} km²</p>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <a href="{{ route('petugas.penduduk.create') }}" 
                           class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-center">
                            Tambah Data Penduduk
                        </a>
                        <a href="{{ route('petugas.laporan.index') }}" 
                           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-center">
                            Buat Laporan
                        </a>
                        <a href="{{ route('petugas.dokumen.index') }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-center">
                            Upload Dokumen
                        </a>
                    </div>

                    <!-- Recent Activities -->
                    @if(isset($recentActivities) && count($recentActivities) > 0)
                    <div class="mt-8">
                        <h3 class="font-bold text-lg mb-4">Aktivitas Terbaru</h3>
                        <div class="space-y-4">
                            @foreach($recentActivities as $activity)
                            <div class="border-l-4 border-indigo-500 pl-4">
                                <p class="text-sm text-gray-600">{{ $activity->created_at->diffForHumans() }}</p>
                                <p class="text-gray-800">{{ $activity->description }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 