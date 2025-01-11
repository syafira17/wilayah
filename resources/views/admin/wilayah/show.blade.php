<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Wilayah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        #map {
            height: 400px;
            width: 100%;
            border-radius: 0.5rem;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen p-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Detail Wilayah</h2>
                    <a href="{{ route('admin.wilayah.index') }}"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Kembali
                    </a>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-gray-600">Kode Wilayah:</p>
                        <p class="font-semibold">{{ $wilayah->kode_wilayah }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Nama Wilayah:</p>
                        <p class="font-semibold">{{ $wilayah->nama_wilayah }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Jenis Wilayah:</p>
                        <p class="font-semibold">{{ ucfirst($wilayah->jenis) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Parent Wilayah:</p>
                        <p class="font-semibold">{{ $wilayah->parent ? $wilayah->parent->nama_wilayah : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Status:</p>
                        <p class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full
                            {{ $wilayah->status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $wilayah->status }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-600">Tanggal Dibuat:</p>
                        <p class="font-semibold">{{ $wilayah->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <div class="mb-6">
                    <p class="text-gray-600 mb-2">Lokasi di Peta:</p>
                    @if($wilayah->latitude && $wilayah->longitude)
                        <div id="map" class="mb-2"></div>
                        <p class="text-sm text-gray-500">
                            Koordinat: {{ $wilayah->latitude }}, {{ $wilayah->longitude }}
                        </p>
                    @else
                        <p class="text-gray-500 italic">Lokasi belum ditentukan</p>
                    @endif
                </div>

                <!-- Data Pendukung -->
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Data Pendukung</h3>
                        <button onclick="document.getElementById('editDetailModal').classList.remove('hidden')"
                            class="bg-blue-500 hover:bg-blue-700 text-white text-sm py-1 px-3 rounded">
                            Edit Data
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-600 text-sm">Jumlah Penduduk:</p>
                            <p class="text-xl font-bold">{{ number_format($wilayah->detail->jumlah_penduduk ?? 0) }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-600 text-sm">Luas Wilayah:</p>
                            <p class="text-xl font-bold">{{ number_format($wilayah->detail->luas_wilayah ?? 0, 2) }} km²</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-600 text-sm">Kepadatan:</p>
                            <p class="text-xl font-bold">
                                @if(($wilayah->detail->luas_wilayah ?? 0) > 0)
                                    {{ number_format(($wilayah->detail->jumlah_penduduk ?? 0) / ($wilayah->detail->luas_wilayah ?? 1), 2) }}/km²
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <p class="text-gray-600 text-sm mb-2">Fasilitas:</p>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            {!! nl2br(e($wilayah->detail->fasilitas ?? 'Belum ada data fasilitas')) !!}
                        </div>
                    </div>
                </div>

                <!-- Dokumen dan Foto -->
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Dokumen & Foto</h3>
                        <button onclick="document.getElementById('uploadModal').classList.remove('hidden')"
                            class="bg-green-500 hover:bg-green-700 text-white text-sm py-1 px-3 rounded">
                            Upload File
                        </button>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @forelse($wilayah->documents as $doc)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                @if($doc->tipe_dokumen === 'foto')
                                    <img src="{{ asset('storage/' . $doc->file_path) }}" 
                                         alt="{{ $doc->nama_dokumen }}"
                                         class="w-full h-32 object-cover rounded mb-2">
                                @else
                                    <div class="w-full h-32 flex items-center justify-center bg-gray-200 rounded mb-2">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                                <p class="font-semibold text-sm truncate">{{ $doc->nama_dokumen }}</p>
                                <p class="text-gray-500 text-xs">{{ $doc->created_at->format('d/m/Y') }}</p>
                                <div class="flex space-x-2 mt-2">
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" 
                                       target="_blank"
                                       class="text-blue-500 hover:text-blue-700 text-sm">
                                        Lihat
                                    </a>
                                    <form action="{{ route('admin.wilayah.documents.destroy', $doc->id) }}" 
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus file ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 text-center py-4 text-gray-500">
                                Belum ada dokumen atau foto
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="flex space-x-4">
                    <a href="{{ route('admin.wilayah.edit', $wilayah->id) }}"
                        class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                        Edit Wilayah
                    </a>
                    <form action="{{ route('admin.wilayah.destroy', $wilayah->id) }}" 
                          method="POST" 
                          class="inline-block" 
                          onsubmit="return confirm('Yakin ingin menghapus wilayah ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Hapus Wilayah
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if($wilayah->latitude && $wilayah->longitude)
    <script>
        // Inisialisasi peta
        const map = L.map('map').setView([{{ $wilayah->latitude }}, {{ $wilayah->longitude }}], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Tambahkan marker
        const marker = L.marker([{{ $wilayah->latitude }}, {{ $wilayah->longitude }}]).addTo(map);
        marker.bindPopup("<strong>{{ $wilayah->nama_wilayah }}</strong><br>{{ ucfirst($wilayah->jenis) }}").openPopup();
    </script>
    @endif

    <!-- Modal Edit Data Pendukung -->
    <div id="editDetailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Edit Data Pendukung</h3>
                    <form action="{{ route('admin.wilayah.details.update', $wilayah->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Jumlah Penduduk
                            </label>
                            <input type="number" name="jumlah_penduduk" 
                                   value="{{ $wilayah->detail->jumlah_penduduk ?? '' }}"
                                   class="shadow appearance-none border rounded w-full py-2 px-3">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Luas Wilayah (km²)
                            </label>
                            <input type="number" step="0.01" name="luas_wilayah" 
                                   value="{{ $wilayah->detail->luas_wilayah ?? '' }}"
                                   class="shadow appearance-none border rounded w-full py-2 px-3">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Fasilitas
                            </label>
                            <textarea name="fasilitas" rows="4"
                                      class="shadow appearance-none border rounded w-full py-2 px-3">{{ $wilayah->detail->fasilitas ?? '' }}</textarea>
                        </div>

                        <div class="flex justify-end space-x-2">
                            <button type="button"
                                    onclick="document.getElementById('editDetailModal').classList.add('hidden')"
                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Batal
                            </button>
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Upload File -->
    <div id="uploadModal" class="fixed inset-0 bg-black bg-opacity-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Upload File</h3>
                    <form action="{{ route('admin.wilayah.documents.store', $wilayah->id) }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Nama File
                            </label>
                            <input type="text" name="nama_dokumen" required
                                   class="shadow appearance-none border rounded w-full py-2 px-3">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Tipe File
                            </label>
                            <select name="tipe_dokumen" required
                                    class="shadow appearance-none border rounded w-full py-2 px-3">
                                <option value="foto">Foto</option>
                                <option value="dokumen">Dokumen</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                File
                            </label>
                            <input type="file" name="file" required
                                   class="shadow appearance-none border rounded w-full py-2 px-3">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Deskripsi
                            </label>
                            <textarea name="deskripsi" rows="3"
                                      class="shadow appearance-none border rounded w-full py-2 px-3"></textarea>
                        </div>

                        <div class="flex justify-end space-x-2">
                            <button type="button"
                                    onclick="document.getElementById('uploadModal').classList.add('hidden')"
                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Batal
                            </button>
                            <button type="submit"
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Upload
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 