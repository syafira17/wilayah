<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Wilayah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold mb-6 text-center">Edit Wilayah</h2>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.wilayah.update', $wilayah->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="kode_wilayah">
                        Kode Wilayah
                    </label>
                    <input type="text" name="kode_wilayah" id="kode_wilayah" required
                        value="{{ old('kode_wilayah', $wilayah->kode_wilayah) }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nama_wilayah">
                        Nama Wilayah
                    </label>
                    <input type="text" name="nama_wilayah" id="nama_wilayah" required
                        value="{{ old('nama_wilayah', $wilayah->nama_wilayah) }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="jenis">
                        Jenis Wilayah
                    </label>
                    <select name="jenis" id="jenis" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @foreach(App\Models\Wilayah::getJenisWilayah() as $key => $value)
                            <option value="{{ $key }}" {{ old('jenis', $wilayah->jenis) == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="parent_id">
                        Parent Wilayah
                    </label>
                    <select name="parent_id" id="parent_id"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Pilih Parent Wilayah (Opsional)</option>
                        @foreach(App\Models\Wilayah::where('id', '!=', $wilayah->id)->get() as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id', $wilayah->parent_id) == $parent->id ? 'selected' : '' }}>
                                {{ ucfirst($parent->jenis) }} - {{ $parent->nama_wilayah }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="deskripsi">
                        Deskripsi
                    </label>
                    <textarea name="deskripsi" id="deskripsi" rows="3"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('deskripsi', $wilayah->deskripsi) }}</textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="status">
                        Status
                    </label>
                    <select name="status" id="status" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="aktif" {{ old('status', $wilayah->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status', $wilayah->status) == 'nonaktif' ? 'selected' : '' }}>Non Aktif</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Lokasi di Peta
                    </label>
                    <div id="map" class="w-full h-96 rounded-lg mb-4"></div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="latitude">
                                Latitude
                            </label>
                            <input type="number" step="any" name="latitude" id="latitude"
                                value="{{ old('latitude', $wilayah->latitude) }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                readonly>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="longitude">
                                Longitude
                            </label>
                            <input type="number" step="any" name="longitude" id="longitude"
                                value="{{ old('longitude', $wilayah->longitude) }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                readonly>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mt-2">Klik pada peta untuk mengubah lokasi</p>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Gambar Wilayah
                    </label>
                    
                    <!-- Preview gambar yang sudah ada -->
                    @if($wilayah->documents()->where('tipe_dokumen', 'foto')->exists())
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            @foreach($wilayah->documents()->where('tipe_dokumen', 'foto')->get() as $foto)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $foto->file_path) }}" 
                                         alt="{{ $foto->nama_dokumen }}"
                                         class="w-full h-40 object-cover rounded-lg">
                                    <form action="{{ route('admin.wilayah.documents.destroy', $foto->id) }}" 
                                          method="POST"
                                          class="absolute top-2 right-2 hidden group-hover:block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-500 hover:bg-red-700 text-white p-2 rounded-full"
                                                onclick="return confirm('Yakin ingin menghapus foto ini?')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Form upload gambar baru -->
                    <div class="mt-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Tambah Gambar Baru
                        </label>
                        <div class="flex items-center space-x-4">
                            <input type="file" name="images[]" multiple accept="image/*"
                                   class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <button type="button" onclick="document.querySelector('input[name=\'images[]\']').click()"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Pilih File
                            </button>
                        </div>
                        <p class="text-sm text-gray-600 mt-2">
                            Dapat memilih beberapa file sekaligus. Format yang didukung: JPG, PNG, GIF
                        </p>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Update Wilayah
                    </button>
                    <a href="{{ route('admin.wilayah.index') }}"
                        class="text-gray-600 hover:text-gray-800">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Inisialisasi peta
        const defaultLat = {{ $wilayah->latitude ?? -2.5489 }};
        const defaultLng = {{ $wilayah->longitude ?? 118.0149 }};
        
        const map = L.map('map').setView([defaultLat, defaultLng], 5);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Tambahkan marker jika ada koordinat
        let marker;
        if (defaultLat && defaultLng) {
            marker = L.marker([defaultLat, defaultLng]).addTo(map);
        }

        // Event ketika peta diklik
        map.on('click', function(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;

            // Update input fields
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            // Update marker
            if (marker) {
                marker.setLatLng([lat, lng]);
            } else {
                marker = L.marker([lat, lng]).addTo(map);
            }
        });
    </script>
</body>
</html> 