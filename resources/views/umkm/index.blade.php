@extends('layouts.app')

@section('content')
<div class="text-center mb-12">
    <h1 class="text-4xl font-bold text-blue-900 mb-2">Etalase Ekonomi Lokal</h1>
    <p class="text-gray-500">Dukung UMKM di lingkungan RT/RW kita.</p>
    
    @auth
    <a href="{{ route('umkm.create') }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full transition duration-300 shadow-lg transform hover:-translate-y-1">
        + Daftarkan Usaha
    </a>
    @endauth
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @foreach($umkms as $umkm)
    <div class="glass rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 group">
        <div class="relative h-48 overflow-hidden">
            <img src="{{ asset('storage/' . $umkm->gambar_logo) }}" alt="{{ $umkm->nama_usaha }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
            <div class="absolute top-0 right-0 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-bl-lg">
                {{ $umkm->kategori }}
            </div>
        </div>
        <div class="p-6">
            <h2 class="text-xl font-bold mb-2 text-gray-800">{{ $umkm->nama_usaha }}</h2>
            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $umkm->deskripsi }}</p>
            
            <div class="flex items-center justify-between mt-4">
                <span class="text-xs font-semibold bg-gray-200 text-gray-700 px-2 py-1 rounded">
                    RT {{ $umkm->rt }} / RW {{ $umkm->rw }}
                </span>
                <a href="{{ route('umkm.show', $umkm->umkm_id) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                    Lihat Produk &rarr;
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="mt-10">
    {{ $umkms->links() }}
</div>
@endsection