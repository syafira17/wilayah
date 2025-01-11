<!DOCTYPE html>
<html>
<head>
    <title>Detail Wilayah - {{ $wilayah->nama_wilayah }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-xl font-semibold">Detail Wilayah</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('wilayah.index') }}" class="text-gray-700 hover:text-gray-900">Kembali</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ $wilayah->nama_wilayah }}
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    {{ ucfirst($wilayah->jenis) }}
                </p>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Kode Wilayah</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $wilayah->kode_wilayah }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Wilayah Induk</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $wilayah->parent ? $wilayah->parent->nama_wilayah : '-' }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Jumlah Penduduk</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ number_format($wilayah->detail->jumlah_penduduk ?? 0) }} jiwa
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Luas Wilayah</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ number_format($wilayah->detail->luas_wilayah ?? 0, 2) }} km²
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Fasilitas</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $wilayah->detail->fasilitas ?? '-' }}
                        </dd>
                    </div>
                    @if($wilayah->documents->isNotEmpty())
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Foto/Dokumen</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <div class="grid grid-cols-3 gap-4">
                                    @foreach($wilayah->documents as $document)
                                        @if($document->tipe_dokumen === 'foto')
                                            <div>
                                                <img src="{{ Storage::url($document->file_path) }}" 
                                                     alt="{{ $document->nama_dokumen }}"
                                                     class="w-full h-32 object-cover rounded">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>
    </div>
</body>
</html> 