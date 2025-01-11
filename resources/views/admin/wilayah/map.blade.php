<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Wilayah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        #map {
            height: 600px;
            width: 100%;
            border-radius: 0.5rem;
        }
    </style>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-xl font-semibold">Admin Dashboard</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-gray-900">Dashboard</a>
                    <a href="{{ route('admin.wilayah.index') }}" class="text-gray-700 hover:text-gray-900">Wilayah</a>
                    <a href="{{ route('admin.wilayah.map') }}" class="text-gray-700 hover:text-gray-900">Peta</a>
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

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Peta Wilayah</h2>
                <div class="flex space-x-4">
                    <select id="filterJenis" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Semua Jenis</option>
                        @foreach(App\Models\Wilayah::getJenisWilayah() as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div id="map"></div>
            </div>

            <!-- Legend -->
            <div class="mt-4 bg-white rounded-lg shadow-lg p-4">
                <h3 class="font-semibold mb-2">Legenda:</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="flex items-center">
                        <div class="w-4 h-4 rounded-full bg-red-500 mr-2"></div>
                        <span>Provinsi</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 rounded-full bg-blue-500 mr-2"></div>
                        <span>Kabupaten</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 rounded-full bg-green-500 mr-2"></div>
                        <span>Kecamatan</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 rounded-full bg-yellow-500 mr-2"></div>
                        <span>Desa</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Inisialisasi peta
        const map = L.map('map').setView([-2.5489, 118.0149], 5); // Koordinat Indonesia

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Data wilayah dari server
        const wilayahData = @json($wilayah);

        // Warna berdasarkan jenis wilayah
        const colors = {
            'provinsi': 'red',
            'kabupaten': 'blue',
            'kecamatan': 'green',
            'desa': 'yellow'
        };

        // Layer groups untuk filter
        const layers = {
            'provinsi': L.layerGroup(),
            'kabupaten': L.layerGroup(),
            'kecamatan': L.layerGroup(),
            'desa': L.layerGroup()
        };

        // Tambahkan marker untuk setiap wilayah
        wilayahData.forEach(wilayah => {
            if (wilayah.latitude && wilayah.longitude) {
                const marker = L.circleMarker([wilayah.latitude, wilayah.longitude], {
                    radius: 8,
                    fillColor: colors[wilayah.jenis],
                    color: '#fff',
                    weight: 1,
                    opacity: 1,
                    fillOpacity: 0.8
                });

                marker.bindPopup(`
                    <strong>${wilayah.nama_wilayah}</strong><br>
                    Jenis: ${wilayah.jenis}<br>
                    Kode: ${wilayah.kode_wilayah}<br>
                    Status: ${wilayah.status}
                `);

                layers[wilayah.jenis].addLayer(marker);
            }
        });

        // Tambahkan semua layer ke peta
        Object.values(layers).forEach(layer => map.addLayer(layer));

        // Filter berdasarkan jenis wilayah
        document.getElementById('filterJenis').addEventListener('change', function(e) {
            const selectedJenis = e.target.value;

            Object.entries(layers).forEach(([jenis, layer]) => {
                if (!selectedJenis || selectedJenis === jenis) {
                    map.addLayer(layer);
                } else {
                    map.removeLayer(layer);
                }
            });
        });
    </script>
</body>
</html> 