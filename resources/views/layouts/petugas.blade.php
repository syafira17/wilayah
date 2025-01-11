<!-- Di bagian navbar, tambahkan menu profil -->
<div class="flex items-center space-x-4">
    <div class="relative" x-data="{ open: false }">
        <button @click="open = !open" class="flex items-center space-x-2">
            <img src="{{ auth()->user()->avatar_url }}" 
                 alt="Profile" 
                 class="h-8 w-8 rounded-full object-cover">
            <span class="text-gray-700">{{ auth()->user()->name }}</span>
        </button>
        
        <div x-show="open" 
             @click.away="open = false"
             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
            <a href="{{ route('profile.show') }}" 
               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                Profil Saya
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" 
                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Logout
                </button>
            </form>
        </div>
    </div>
</div> 