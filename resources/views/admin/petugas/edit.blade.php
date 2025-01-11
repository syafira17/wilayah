<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Petugas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold mb-6 text-center">Edit Petugas</h2>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.petugas.update', $petugas->id) }}" class="space-y-4">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name', $petugas->name) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email', $petugas->email) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" 
                           name="password"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Wilayah Tugas</label>
                    <select name="wilayah_id" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            required>
                        <option value="">Pilih Wilayah</option>
                        @foreach($wilayah as $w)
                            <option value="{{ $w->id }}" {{ (old('wilayah_id', $petugas->wilayah_id) == $w->id) ? 'selected' : '' }}>
                                {{ $w->nama_wilayah }} ({{ $w->kode_wilayah }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.petugas.index') }}" 
                       class="inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                        Kembali
                    </a>
                    <button type="submit"
                            class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html> 