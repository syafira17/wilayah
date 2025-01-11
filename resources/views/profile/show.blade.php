@extends('layouts.' . (auth()->user()->role === 'user' ? 'user' : (auth()->user()->role === 'admin' ? 'admin' : 'petugas')))

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">Profil Pengguna</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Informasi detail profil Anda</p>
            </div>
            <a href="{{ route('profile.edit') }}" 
               class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                Edit Profil
            </a>
        </div>
        <div class="border-t border-gray-200">
            <div class="flex justify-center py-5">
                <div class="w-32 h-32 rounded-full overflow-hidden">
                    <img src="{{ auth()->user()->avatar_url }}" 
                         alt="{{ auth()->user()->name }}"
                         class="w-full h-full object-cover">
                </div>
            </div>
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ auth()->user()->name }}
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ auth()->user()->email }}
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Role</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ ucfirst(auth()->user()->role) }}
                    </dd>
                </div>
                @if(auth()->user()->role === 'petugas')
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Wilayah Tugas</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ auth()->user()->wilayah->nama_wilayah ?? '-' }}
                        </dd>
                    </div>
                @endif
            </dl>
        </div>
    </div>
</div>
@endsection 