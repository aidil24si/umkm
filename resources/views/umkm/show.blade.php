@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex items-start gap-6">
        @if($umkm->gambar_logo)
            <img src="{{ asset('storage/' . $umkm->gambar_logo) }}" class="w-32 h-32 object-cover rounded" alt="logo">
        @endif
        <div>
            <h1 class="text-2xl font-bold">{{ $umkm->nama_usaha }}</h1>
            <p class="text-sm text-gray-600">{{ $umkm->alamat }}</p>
            <p class="mt-2 text-sm">Kategori: <span class="font-semibold">{{ $umkm->kategori }}</span></p>
        </div>
        @auth
            @if(auth()->id() === $umkm->pemilik_warga_id || auth()->user()->role === 'admin')
                <div class="ml-auto">
                    <a href="{{ route('umkm.edit', $umkm->umkm_id) }}" class="bg-blue-600 text-white px-4 py-2 rounded">Edit UMKM</a>
                </div>
            @endif
        @endauth
    </div>

    <hr class="my-6">

    <h2 class="text-xl font-bold mb-4">Produk dari {{ $umkm->nama_usaha }}</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @forelse($umkm->produk as $produk)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                @if($produk->gambar_produk)
                    <img src="{{ asset('storage/' . $produk->gambar_produk) }}" class="w-full h-44 object-cover">
                    <div class="p-2 text-xs text-gray-400">URL: <a href="{{ asset('storage/' . $produk->gambar_produk) }}" target="_blank">{{ asset('storage/' . $produk->gambar_produk) }}</a></div>
                @else
                    <img src="https://source.unsplash.com/400x300/?product" class="w-full h-44 object-cover">
                @endif
                <div class="p-4">
                    <h3 class="font-semibold">{{ $produk->nama_produk }}</h3>
                    <p class="text-sm text-gray-500">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                </div>
            </div>
        @empty
            <p class="text-gray-600">Belum ada produk.</p>
        @endforelse
    </div>

    @auth
        @if(auth()->id() === $umkm->pemilik_warga_id || auth()->user()->role === 'admin')
            <div class="mt-6 flex items-center gap-3">
                <a href="{{ route('produk.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Tambah Produk</a>

                @if(auth()->user()->role === 'admin' && $umkm->gambar_logo)
                    <form method="POST" action="{{ route('admin.settings.logo.from_umkm', $umkm->umkm_id) }}" onsubmit="return confirm('Set logo situs dari logo UMKM ini?')">
                        @csrf
                        <button class="px-4 py-2 border rounded bg-yellow-400 text-white">Jadikan Logo Situs</button>
                    </form>
                @endif
            </div>
        @endif
    @endauth
</div>
@endsection