@extends('layouts.' . (auth()->user()->role === 'user' ? 'user' : (auth()->user()->role === 'admin' ? 'admin' : 'petugas')))

@section('title', 'Edit Profil')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Profil</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Update informasi profil Anda</p>
            </div>

            <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 gap-6">
                    <!-- Avatar -->
                    <div class="flex flex-col items-center">
                        <div class="w-32 h-32 rounded-full overflow-hidden mb-4">
                            <img src="{{ auth()->user()->avatar_url }}" 
                                 alt="Preview"
                                 id="avatar-preview"
                                 class="w-full h-full object-cover">
                        </div>
                        <input type="file" 
                               name="avatar" 
                               id="avatar"
                               accept="image/*"
                               class="hidden"
                               onchange="previewImage(event)">
                        <label for="avatar" 
                               class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded cursor-pointer">
                            Pilih Foto
                        </label>
                        @error('avatar')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" 
                               name="name" 
                               value="{{ old('name', auth()->user()->name) }}"
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
                               value="{{ old('email', auth()->user()->email) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="border-t pt-4">
                        <h4 class="text-md font-medium text-gray-900 mb-4">Ubah Password (opsional)</h4>
                        
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Password Saat Ini</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="password" 
                                           name="current_password"
                                           id="current_password"
                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <button type="button" 
                                                onclick="togglePassword('current_password')"
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
                                @error('current_password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Password Baru</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="password" 
                                           name="new_password"
                                           id="new_password"
                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <button type="button" 
                                                onclick="togglePassword('new_password')"
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
                                @error('new_password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="password" 
                                           name="new_password_confirmation"
                                           id="new_password_confirmation"
                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <button type="button" 
                                                onclick="togglePassword('new_password_confirmation')"
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
            </div>

            <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                <a href="{{ route('profile.show') }}" 
                   class="inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Batal
                </a>
                <button type="submit"
                        class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
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

function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const preview = document.getElementById('avatar-preview');
        preview.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endpush
@endsection 