<nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 shadow-sm">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <a href="/" class="flex items-center space-x-3">
                @php $siteLogo = null; @endphp
                @if(\Illuminate\Support\Facades\Storage::disk('public')->exists('site/logo.png'))
                    @php $siteLogo = asset('storage/site/logo.png'); @endphp
                @endif

                @if($siteLogo)
                    <div class="relative">
                        <a @if(Auth::check() && Auth::user()->role === 'admin') href="{{ route('admin.settings') }}" title="Edit logo situs" @endif>
                            <img src="{{ $siteLogo }}" class="w-10 h-10 rounded-full object-cover" alt="logo">
                        </a>

                        @if(Auth::check() && Auth::user()->role === 'admin')
                            <a href="{{ route('admin.settings') }}" class="absolute -bottom-1 -right-1 bg-white rounded-full p-1 shadow border" title="Edit Logo">
                                <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6.5-6.5 3.5 3.5L12.5 14.5 9 11z"></path></svg>
                            </a>
                        @endif
                    </div>
                @else
                    <div class="bg-blue-600 text-white rounded-full w-10 h-10 flex items-center justify-center font-bold">UK</div>
                @endif

                <div class="text-2xl font-bold text-blue-800 tracking-tighter">UMKM<span class="text-yellow-500">Kita</span></div>
            </a>

            <div class="hidden md:flex space-x-6 items-center">
                <a href="{{ route('umkm.index') }}" class="text-gray-600 hover:text-blue-600 transition">Jelajah</a>
                @auth
                    <a href="{{ route('umkm.daftar') }}" class="text-gray-600 hover:text-blue-600 transition">Daftar Usaha</a>
                @endauth
                <a href="{{ route('pesanan.index') }}" class="text-gray-600 hover:text-blue-600 transition">Pesanan</a>
                <a href="{{ route('produk.index') }}" class="text-gray-600 hover:text-blue-600 transition">Produk</a>
            </div>

            <div class="hidden md:flex items-center space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="text-blue-600 font-medium">Masuk</a>
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700 transition">Daftar</a>
                @else
                    <div x-data="{open:false}" class="relative">
                        <button @click="open = !open" class="flex items-center space-x-2 border px-3 py-1 rounded-md">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-8 h-8 rounded-full object-cover">
                            @endif
                            <span class="text-sm">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg py-1 border">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit Profil</a>

                            @if(Auth::user()->role == 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard Admin</a>
                                <a href="{{ route('admin.settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pengaturan Logo</a>
                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm bg-red-600 text-white rounded hover:bg-red-700">Keluar</button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button id="mobileMenuBtn" class="p-2 rounded-md border">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobileMenu" class="hidden md:hidden mt-2">
            <a href="{{ route('umkm.index') }}" class="block px-4 py-2 text-gray-700">Jelajah</a>
            @auth
                <a href="{{ route('umkm.daftar') }}" class="block px-4 py-2 text-gray-700">Daftar Usaha</a>
            @endauth
            <a href="{{ route('pesanan.index') }}" class="block px-4 py-2 text-gray-700">Pesanan</a>
            <a href="{{ route('produk.index') }}" class="block px-4 py-2 text-gray-700">Produk</a>

            @auth
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700">Edit Profil</a>
                @if(Auth::user()->role == 'admin')
                    <a href="{{ route('admin.settings') }}" class="block px-4 py-2 text-gray-700">Pengaturan Logo</a>
                @endif
            @endauth

            @guest
                <a href="{{ route('login') }}" class="block px-4 py-2 text-blue-600">Masuk</a>
                <a href="{{ route('register') }}" class="block px-4 py-2 bg-blue-600 text-white rounded-md mx-2 text-center">Daftar</a>
            @else
                <form method="POST" action="{{ route('logout') }}" class="px-4 py-2">
                    @csrf
                    <button type="submit" class="w-full text-left text-red-600">Keluar</button>
                </form>
            @endguest
        </div>
    </div>

    <script>
        document.getElementById('mobileMenuBtn').addEventListener('click', function() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        });
    </script>
</nav>