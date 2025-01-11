@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700">
        Edit User
    </h2>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6">
                <!-- Nama -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name', $user->name) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email', $user->email) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Role</label>
                    <select name="role" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            onchange="toggleWilayah(this.value)">
                        <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                        <option value="petugas" {{ old('role', $user->role) === 'petugas' ? 'selected' : '' }}>Petugas</option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Wilayah (hanya untuk petugas) -->
                <div id="wilayah_section" style="{{ old('role', $user->role) !== 'petugas' ? 'display: none;' : '' }}">
                    <label class="block text-sm font-medium text-gray-700">Wilayah Tugas</label>
                    <select name="wilayah_id" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Pilih Wilayah</option>
                        @foreach($wilayah as $w)
                            <option value="{{ $w->id }}" 
                                {{ old('wilayah_id', $user->wilayah_id) == $w->id ? 'selected' : '' }}>
                                {{ $w->nama_wilayah }}
                            </option>
                        @endforeach
                    </select>
                    @error('wilayah_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="border-t pt-4">
                    <h4 class="text-md font-medium text-gray-900 mb-4">Ubah Password (opsional)</h4>
                    
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Password Baru</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="password" 
                                       name="password"
                                       id="password"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <button type="button" 
                                            onclick="togglePassword('password')"
                                            class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" 
                                             class="h-5 w-5" 
                                             fill="none"
                                             viewBox="0 0 24 24" 
                                             stroke="currentColor">
                                            <path stroke-linecap="round" 
                                                  stroke-linejoin="round" 
                                                  stroke-width="2" 
                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" 
                                                  stroke-linejoin="round" 
                                                  stroke-width="2" 
                                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="password" 
                                       name="password_confirmation"
                                       id="password_confirmation"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <button type="button" 
                                            onclick="togglePassword('password_confirmation')"
                                            class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" 
                                             class="h-5 w-5" 
                                             fill="none"
                                             viewBox="0 0 24 24" 
                                             stroke="currentColor">
                                            <path stroke-linecap="round" 
                                                  stroke-linejoin="round" 
                                                  stroke-width="2" 
                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" 
                                                  stroke-linejoin="round" 
                                                  stroke-width="2" 
                                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.users.index') }}" 
                   class="inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
    input.setAttribute('type', type);
}

function toggleWilayah(role) {
    const wilayahSection = document.getElementById('wilayah_section');
    wilayahSection.style.display = role === 'petugas' ? 'block' : 'none';
}
</script>
@endpush
@endsection 