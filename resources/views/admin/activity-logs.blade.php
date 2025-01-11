<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Aktivitas</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
            <h2 class="text-2xl font-bold mb-4">Riwayat Aktivitas</h2>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengguna</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Wilayah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aktivitas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail</th>
                            <th class="px-6 py-3">IP Address</th>
                            <th class="px-6 py-3">Browser</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($logs as $log)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $log->created_at->format('d/m/Y H:i:s') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $log->user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $log->wilayah->nama_wilayah }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $log->description }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($log->old_values && $log->new_values)
                                        <button onclick="showChanges('{{ json_encode($log->old_values) }}', '{{ json_encode($log->new_values) }}')"
                                                class="text-blue-600 hover:text-blue-900">
                                            Lihat Perubahan
                                        </button>
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ $log->ip_address }}</td>
                                <td class="px-6 py-4">{{ $log->user_agent }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $logs->links() }}
            </div>
        </div>
    </div>

    <!-- Modal untuk menampilkan perubahan -->
    <div id="changesModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Detail Perubahan</h3>
                <div class="mt-2 px-7 py-3">
                    <div id="changesContent" class="text-left"></div>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="closeModal" class="px-4 py-2 bg-gray-500 text-white rounded-md">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showChanges(oldValues, newValues) {
            const old = JSON.parse(oldValues);
            const new_ = JSON.parse(newValues);
            let content = '';

            for (const key in new_) {
                if (old[key] !== new_[key]) {
                    content += `<p class="mb-2">
                        <span class="font-bold">${key}:</span><br>
                        <span class="text-red-500">- ${old[key]}</span><br>
                        <span class="text-green-500">+ ${new_[key]}</span>
                    </p>`;
                }
            }

            document.getElementById('changesContent').innerHTML = content;
            document.getElementById('changesModal').classList.remove('hidden');
        }

        document.getElementById('closeModal').onclick = function() {
            document.getElementById('changesModal').classList.add('hidden');
        }

        function applyFilters() {
            const type = document.getElementById('filterType').value;
            const date = document.getElementById('filterDate').value;
            
            window.location.href = `{{ route('admin.activity-logs') }}?type=${type}&date=${date}`;
        }
    </script>
</body>
</html> 