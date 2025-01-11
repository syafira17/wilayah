<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Wilayah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold mb-6 text-center">Tambah Wilayah Baru</h2>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.wilayah.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="kode_wilayah">
                        Kode Wilayah
                    </label>
                    <input type="text" name="kode_wilayah" id="kode_wilayah" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nama_wilayah">
                        Nama Wilayah
                    </label>
                    <input type="text" name="nama_wilayah" id="nama_wilayah" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="jumlah_penduduk">
                        Jumlah Penduduk
                    </label>
                    <input type="number" name="jumlah_penduduk" id="jumlah_penduduk"
                        value="{{ old('jumlah_penduduk', 0) }}"
                        min="0"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="luas_wilayah">
                        Luas Wilayah (km²)
                    </label>
                    <input type="number" name="luas_wilayah" id="luas_wilayah"
                        value="{{ old('luas_wilayah', 0) }}"
                        min="0" step="0.01"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="fasilitas">
                        Fasilitas
                    </label>
                    <textarea name="fasilitas" id="fasilitas" rows="3"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('fasilitas') }}</textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="status">
                        Status
                    </label>
                    <select name="status" id="status" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Non Aktif</option>
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
                                value="{{ old('latitude') }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                readonly>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="longitude">
                                Longitude
                            </label>
                            <input type="number" step="any" name="longitude" id="longitude"
                                value="{{ old('longitude') }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                readonly>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mt-2">Klik pada peta untuk memilih lokasi</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="jenis">
                        Jenis Wilayah
                    </label>
                    <select name="jenis" id="jenis" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Pilih Jenis Wilayah</option>
                        @foreach($jenisWilayah as $key => $value)
                            <option value="{{ $key }}" {{ old('jenis') == $key ? 'selected' : '' }}>
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
                        @foreach($parentWilayah as $pw)
                            <option value="{{ $pw->id }}" {{ old('parent_id') == $pw->id ? 'selected' : '' }}>
                                {{ ucfirst($pw->jenis) }} - {{ $pw->nama_wilayah }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Gambar Wilayah
                    </label>
                    <div class="mt-2">
                        <input type="file" name="images[]" multiple accept="image/*"
                               class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <p class="text-sm text-gray-600 mt-2">
                            Dapat memilih beberapa file sekaligus. Format yang didukung: JPG, PNG, GIF (max 2MB)
                        </p>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Tambah Wilayah
                    </button>
                    <a href="{{ route('admin.wilayah.index') }}"
                        class="text-gray-600 hover:text-gray-800">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Inisialisasi peta
        const map = L.map('map').setView([-2.5489, 118.0149], 5); // Koordinat default Indonesia

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        let marker;

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