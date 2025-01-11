<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login History</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-xl font-semibold">Admin Dashboard</span>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-gray-900 mx-3">Dashboard</a>
                    <a href="{{ route('admin.petugas.index') }}" class="text-gray-700 hover:text-gray-900 mx-3">Petugas</a>
                    <form action="{{ route('logout') }}" method="POST" class="ml-3">
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
            <h2 class="text-2xl font-bold mb-6">Login History</h2>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Login Time</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($loginHistory as $history)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $history->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $history->user->role }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $history->ip_address }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $history->login_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html> 