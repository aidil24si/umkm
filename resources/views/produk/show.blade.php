@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 bg-white rounded-lg shadow p-4">
        @if($produk->gambar_produk)
            <img src="{{ asset('storage/' . $produk->gambar_produk) }}" class="w-full h-96 object-cover rounded-md" alt="{{ $produk->nama_produk }}">
        @else
            <img src="https://source.unsplash.com/800x500/?product" class="w-full h-96 object-cover rounded-md" alt="{{ $produk->nama_produk }}">
        @endif

        <h1 class="text-2xl font-bold mt-4">{{ $produk->nama_produk }}</h1>
        <p class="text-gray-600 mt-2">{{ $produk->deskripsi }}</p>

        @if($produk->images->count())
            <div class="mt-4">
                <h3 class="font-semibold mb-2">Gallery</h3>
                <div class="grid grid-cols-3 gap-4">
                    @foreach($produk->images as $img)
                        <a href="{{ asset('storage/' . $img->path) }}" target="_blank" class="block">
                            <img src="{{ asset('storage/' . $img->path) }}" class="w-full h-40 object-cover rounded" alt="Gambar produk">
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <aside class="bg-white rounded-lg shadow p-4">
        <div class="text-center">
            <div class="text-2xl font-bold text-blue-600">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>
            <div class="text-sm text-gray-500 mt-2">Stok: {{ $produk->stok }}</div>

            @auth
                <form method="POST" action="{{ route('pesanan.quick', $produk->produk_id) }}" class="mt-4">
                    @csrf
                    <input type="hidden" name="qty" value="1">
                    <button class="w-full bg-green-600 text-white px-4 py-2 rounded-md">Tambah Pesanan</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="w-full inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded-md text-center">Masuk untuk pesan</a>
            @endauth

            <form method="POST" action="{{ route('checkout') }}" class="mt-2">
                @csrf
                <input type="hidden" name="produk_id" value="{{ $produk->produk_id }}">
                <button class="w-full bg-blue-600 text-white px-4 py-2 rounded-md">Beli Sekarang</button>
            </form>
        </div>
    </aside>
</div>
@endsection