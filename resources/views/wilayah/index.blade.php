@extends('layouts.user')

@section('title', 'Data Wilayah')

@section('content')
    <!-- Filter dan Pencarian -->
    <div class="mb-6 bg-white rounded-lg shadow p-4">
        <form action="{{ route('wilayah.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                <input type="text" 
                       name="search" 
                       placeholder="Cari nama atau kode wilayah..."
                       value="{{ request('search') }}"
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Wilayah</label>
                <select name="jenis" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Semua Jenis</option>
                    @foreach($jenisWilayah as $key => $value)
                        <option value="{{ $key }}" {{ request('jenis') == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end space-x-2">
                <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Filter
                </button>
                <a href="{{ route('wilayah.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Daftar Wilayah -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Wilayah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Wilayah Induk</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($wilayah as $index => $w)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $wilayah->firstItem() + $index }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $w->kode_wilayah }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $w->nama_wilayah }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($w->jenis) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $w->parent ? $w->parent->nama_wilayah : '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $w->status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($w->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('wilayah.show', $w->id) }}" 
                               class="text-indigo-600 hover:text-indigo-900">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada data wilayah
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $wilayah->links() }}
    </div>
@endsection 