@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold">Daftar Usaha Saya</h2>
        <div class="flex items-center gap-3">
            <form method="GET" action="{{ route('umkm.daftar') }}" class="flex items-center">
                <input type="text" name="q" placeholder="Cari nama, kategori, atau kontak" value="{{ request('q') }}" class="border p-2 rounded-l-md">
                <button class="bg-gray-200 border-l px-3 rounded-r-md">Cari</button>
            </form>
            <a href="{{ route('umkm.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ Daftarkan Usaha</a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if($umkms->isEmpty())
        <div class="text-center text-gray-500">Belum ada usaha. Coba klik "Daftarkan Usaha" untuk menambahkan.</div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr class="w-full bg-gray-50">
                        <th class="px-4 py-3 text-left text-sm font-semibold">ID</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Nama Usaha</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Kategori</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Kontak</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">RT/RW</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Alamat</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Dibuat</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($umkms as $umkm)
                        <tr>
                            <td class="px-4 py-3 text-sm">{{ $umkm->umkm_id }}</td>
                            <td class="px-4 py-3 text-sm flex items-center gap-3">
                                <img src="{{ asset('storage/' . ($umkm->gambar_logo ?? '')) }}" alt="logo" class="w-12 h-12 object-cover rounded">
                                <div>
                                    <div class="font-semibold">{{ $umkm->nama_usaha }}</div>
                                    <div class="text-xs text-gray-500">{{ \Illuminate\Support\Str::limit($umkm->deskripsi, 60) }}</div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm">{{ $umkm->kategori }}</td>
                            <td class="px-4 py-3 text-sm">{{ $umkm->kontak }}</td>
                            <td class="px-4 py-3 text-sm">RT {{ $umkm->rt }} / RW {{ $umkm->rw }}</td>
                            <td class="px-4 py-3 text-sm">{{ \Illuminate\Support\Str::limit($umkm->alamat, 60) }}</td>
                            <td class="px-4 py-3 text-sm">{{ $umkm->created_at->format('Y-m-d') }}</td>
                            <td class="px-4 py-3 text-sm">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('umkm.show', $umkm->umkm_id) }}" class="px-3 py-1 border rounded">Lihat</a>
                                    <a href="{{ route('umkm.edit', $umkm->umkm_id) }}" class="px-3 py-1 bg-green-600 text-white rounded">Edit</a>
                                    <a href="{{ route('produk.create', ['umkm_id' => $umkm->umkm_id]) }}" class="px-3 py-1 bg-blue-600 text-white rounded">Tambah Produk</a>
                                    <a href="{{ route('produk.index', ['umkm' => $umkm->umkm_id]) }}" class="px-3 py-1 border rounded">Kelola Produk</a>
                                    <form action="{{ route('umkm.destroy', $umkm->umkm_id) }}" method="POST" onsubmit="return confirm('Hapus usaha ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $umkms->links() }}
        </div>
    @endif
</div>
@endsection