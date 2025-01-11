<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Petugas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen p-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Detail Petugas</h2>
                    <a href="{{ route('admin.petugas.index') }}"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Kembali
                    </a>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-gray-600">Nama:</p>
                        <p class="font-semibold">{{ $petugas->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Email:</p>
                        <p class="font-semibold">{{ $petugas->email }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Tanggal Dibuat:</p>
                        <p class="font-semibold">{{ $petugas->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Terakhir Diupdate:</p>
                        <p class="font-semibold">{{ $petugas->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <h3 class="text-xl font-bold mb-4">Riwayat Login</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Login</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User Agent</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($loginHistory as $history)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $history->login_at }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $history->ip_address }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $history->user_agent }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                        Belum ada riwayat login
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 