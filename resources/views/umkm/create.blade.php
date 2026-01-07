@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-4">Daftarkan UMKM</h2>

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('umkm.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-4">
                <input type="text" name="nama_usaha" placeholder="Nama Usaha" value="{{ old('nama_usaha') }}"
                    class="w-full border p-3 rounded" required>
                <input accept="image/*" type="file" name="gambar_logo" class="w-full" x-data="{
                    error: null,
                    maxBytes: 2048 * 1024,
                    handle(e) {
                        const f = e.target.files[0];
                        if (!f) { this.error = null; return }
                        if (f.size > this.maxBytes) {
                            this.error = 'Ukuran logo melebihi 2MB';
                            e.target.value = null;
                            return
                        }
                        this.error = null
                    }
                }"
                    x-on:change="handle">
                <p class="text-sm text-gray-500">Maksimal 2MB.</p>
                <p x-text="$el.__x ? $el.__x.$data.error : ''" x-show="$el.__x && $el.__x.$data.error"
                    class="text-red-600 text-sm mt-1"></p>
                <input type="text" name="kategori" placeholder="Kategori" value="{{ old('kategori') }}"
                    class="w-full border p-3 rounded" required>
                <input type="text" name="kontak" placeholder="Kontak" value="{{ old('kontak') }}"
                    class="w-full border p-3 rounded" required>
                <input type="text" name="alamat" placeholder="Alamat lengkap" value="{{ old('alamat') }}"
                    class="w-full border p-3 rounded" required>
                <input type="text" name="rt" placeholder="RT" value="{{ old('rt') }}"
                    class="w-full border p-3 rounded">
                <input type="text" name="rw" placeholder="RW" value="{{ old('rw') }}"
                    class="w-full border p-3 rounded">
                <textarea name="deskripsi" placeholder="Deskripsi" class="w-full border p-3 rounded">{{ old('deskripsi') }}</textarea>
                <button class="bg-blue-600 text-white px-4 py-2 rounded">Buka Toko</button>
            </div>
        </form>
    </div>
@endsection
