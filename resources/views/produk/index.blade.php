@extends('layouts.app')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold">Produk</h1>
        @if(isset($currentUmkm) && $currentUmkm)
            <div class="text-sm text-gray-600">Menampilkan produk untuk: <strong>{{ $currentUmkm->nama_usaha }}</strong></div>
        @endif
    </div>
    @auth
        @if(isset($currentUmkm) && $currentUmkm)
            <a href="{{ route('produk.create', ['umkm_id' => $currentUmkm->umkm_id]) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md">Tambah Produk untuk {{ \Illuminate\Support\Str::limit($currentUmkm->nama_usaha, 18) }}</a>
        @else
            <a href="{{ route('produk.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md">Tambah Produk</a>
        @endif
    @endauth
</div>

@if(isset($currentUmkm) && $currentUmkm && (auth()->user()->role == 'admin' || auth()->id() == $currentUmkm->pemilik_warga_id))
    <form method="POST" action="{{ route('produk.bulk') }}" id="bulkForm">
        @csrf
        <div class="flex items-center gap-2 mb-4">
            <select name="action" class="border p-2 rounded">
                <option value="">Aksi bulk</option>
                <option value="publish">Publikasikan</option>
                <option value="unpublish">Arsipkan</option>
            </select>
            <button type="submit" class="bg-gray-800 text-white px-3 py-1 rounded">Terapkan</button>
            <span class="text-sm text-gray-500">Pilih beberapa produk lalu klik Terapkan.</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($produks as $produk)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden relative">
                    <label class="absolute top-2 left-2 bg-white/80 p-1 rounded">
                        <input type="checkbox" name="ids[]" value="{{ $produk->produk_id }}">
                    </label>
                    @if($produk->gambar_produk)
                        <img src="{{ asset('storage/' . $produk->gambar_produk) }}" alt="{{ $produk->nama_produk }}" class="w-full h-48 object-cover">
                    @else
                        <img src="https://source.unsplash.com/400x300/?product" alt="{{ $produk->nama_produk }}" class="w-full h-48 object-cover">
                    @endif
                    <div class="p-4">
                        <h3 class="font-semibold text-lg">{{ $produk->nama_produk }}</h3>
                        <p class="text-sm text-gray-600 mt-1">{{ \Illuminate\Support\Str::limit($produk->deskripsi, 80) }}</p>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-blue-600 font-bold">Rp {{ number_format($produk->harga, 0, ",", ".") }}</span>
                            <a href="{{ route('produk.show', $produk->produk_id) }}" class="text-sm text-gray-600">Lihat</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </form>
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($produks as $produk)
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
                @if($produk->gambar_produk)
                    <img src="{{ asset('storage/' . $produk->gambar_produk) }}" alt="{{ $produk->nama_produk }}" class="w-full h-48 object-cover">
                @else
                    <img src="https://source.unsplash.com/400x300/?product" alt="{{ $produk->nama_produk }}" class="w-full h-48 object-cover">
                @endif
                <div class="p-4">
                    <h3 class="font-semibold text-lg">{{ $produk->nama_produk }}</h3>
                    <p class="text-sm text-gray-600 mt-1">{{ \Illuminate\Support\Str::limit($produk->deskripsi, 80) }}</p>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-blue-600 font-bold">Rp {{ number_format($produk->harga, 0, ",", ".") }}</span>
                        <a href="{{ route('produk.show', $produk->produk_id) }}" class="text-sm text-gray-600">Lihat</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

<div class="mt-8">
    {{-- minimal pagination --}}
    {{ $produks->links() }}
</div>
@endsection