<footer class="mt-12 py-12 bg-white border-t">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <h4 class="font-bold mb-2">Etalase Ekonomi Lokal</h4>
                <p class="text-sm text-gray-600">Dukung UMKM lokal, temukan produk berkualitas dari tetangga Anda.</p>
            </div>

            <div>
                <h4 class="font-bold mb-2">Menu</h4>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li><a href="{{ route('umkm.index') }}" class="hover:underline">Jelajah UMKM</a></li>
                    <li><a href="{{ route('produk.index') }}" class="hover:underline">Produk</a></li>
                    <li><a href="/" class="hover:underline">Tentang</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold mb-2">Ikuti Kami</h4>
                <div class="flex space-x-3">
                    <a href="#" class="text-gray-600 hover:text-blue-600">Twitter</a>
                    <a href="#" class="text-gray-600 hover:text-blue-600">Instagram</a>
                    <a href="#" class="text-gray-600 hover:text-blue-600">Facebook</a>
                </div>
            </div>
        </div>

        <div class="mt-6 text-center text-sm text-gray-500">&copy; {{ date('Y') }} Etalase Ekonomi Lokal. All rights reserved.</div>
    </div>
</footer>
