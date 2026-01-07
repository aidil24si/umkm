<section class="bg-gradient-to-br from-blue-50 to-white py-20">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 leading-tight">Etalase Ekonomi Lokal<br><span class="text-blue-600">Dukung UMKM di Sekitar Anda</span></h1>
                <p class="mt-4 text-gray-600">Jelajahi produk lokal, dukung usaha warga, dan belanja langsung dari pemilik usaha.</p>

                <div class="mt-6 flex space-x-3">
                    <a href="{{ route('umkm.index') }}" class="bg-blue-600 text-white px-5 py-3 rounded-md shadow hover:bg-blue-700 transition">Jelajah Sekarang</a>
                    <a href="{{ route('register') }}" class="bg-white border border-blue-600 text-blue-600 px-5 py-3 rounded-md hover:bg-blue-50 transition">Buka Toko</a>
                </div>

                <form action="{{ route('umkm.index') }}" method="GET" class="mt-6">
                    <div class="flex items-center bg-white rounded-md p-2 border shadow-sm">
                        <input type="text" name="q" placeholder="Cari nama UMKM atau kategori..." class="flex-1 px-3 py-2 outline-none" />
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-md">Cari</button>
                    </div>
                </form>
            </div>

            <div>
                <div class="bg-white rounded-lg shadow p-4">
                    <img src="https://source.unsplash.com/600x400/?market,shop" alt="Etalase" class="w-full h-64 object-cover rounded-md">
                </div>
            </div>
        </div>
    </div>
</section>