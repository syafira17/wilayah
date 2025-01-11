<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik Wilayah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    <a href="{{ route('admin.petugas.index') }}" class="text-gray-700 hover:text-gray-900">Petugas</a>
                    <a href="{{ route('admin.wilayah.index') }}" class="text-gray-700 hover:text-gray-900">Wilayah</a>
                    <a href="{{ route('admin.statistics') }}" class="text-gray-700 hover:text-gray-900">Statistik</a>
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
        <h2 class="text-2xl font-bold mb-6">Statistik Wilayah</h2>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-700">Total Wilayah</h3>
                <p class="text-3xl font-bold text-blue-600">{{ $summary['total_wilayah'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-700">Wilayah Aktif</h3>
                <p class="text-3xl font-bold text-green-600">{{ $summary['wilayah_aktif'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-700">Wilayah Non-Aktif</h3>
                <p class="text-3xl font-bold text-red-600">{{ $summary['wilayah_nonaktif'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-700">Total Provinsi</h3>
                <p class="text-3xl font-bold text-purple-600">{{ $summary['provinsi'] }}</p>
            </div>
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Pie Chart -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Distribusi Jenis Wilayah</h3>
                <canvas id="jenisChart"></canvas>
            </div>

            <!-- Bar Chart -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Status Wilayah</h3>
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <!-- Detailed Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-700">Ringkasan Detail</h3>
            </div>
            <div class="p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Provinsi</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $summary['provinsi'] }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Kabupaten</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $summary['kabupaten'] }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Kecamatan</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $summary['kecamatan'] }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Desa</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $summary['desa'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Data untuk charts
        const jenisData = @json($wilayahByJenis);
        const statusData = @json($wilayahByStatus);

        // Pie Chart untuk Jenis Wilayah
        new Chart(document.getElementById('jenisChart'), {
            type: 'pie',
            data: {
                labels: jenisData.map(item => item.jenis.charAt(0).toUpperCase() + item.jenis.slice(1)),
                datasets: [{
                    data: jenisData.map(item => item.total),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Bar Chart untuk Status Wilayah
        new Chart(document.getElementById('statusChart'), {
            type: 'bar',
            data: {
                labels: statusData.map(item => item.status.charAt(0).toUpperCase() + item.status.slice(1)),
                datasets: [{
                    label: 'Jumlah Wilayah',
                    data: statusData.map(item => item.total),
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(255, 99, 132, 0.8)'
                    ]
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
</body>
</html> 