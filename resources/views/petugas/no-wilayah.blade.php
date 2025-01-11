@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-lg mx-auto bg-white rounded-lg shadow-lg p-8">
        <div class="text-center">
            <!-- Icon Warning -->
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-yellow-100 mb-4">
                <svg class="h-10 w-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-gray-900 mb-4">
                Wilayah Belum Ditugaskan
            </h2>

            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            Anda belum ditugaskan ke wilayah manapun. Silahkan hubungi admin untuk mendapatkan penugasan wilayah.
                        </p>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <p class="text-gray-600">
                    Untuk dapat mengakses fitur-fitur petugas, Anda memerlukan penugasan wilayah dari admin.
                </p>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-700 mb-2">Langkah yang harus dilakukan:</h3>
                    <ol class="list-decimal list-inside text-left text-gray-600 space-y-2">
                        <li>Hubungi admin sistem</li>
                        <li>Minta untuk ditugaskan ke wilayah tertentu</li>
                        <li>Setelah ditugaskan, login kembali ke sistem</li>
                    </ol>
                </div>

                <div class="mt-6">
                    <form method="POST" action="{{ route('logout') }}" class="inline-block">
                        @csrf
                        <button type="submit" 
                                class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 