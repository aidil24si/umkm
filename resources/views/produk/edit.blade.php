@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-4">Edit Produk</h2>

        <form method="POST" action="{{ route('produk.update', $produk->produk_id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-4">
                <label class="text-sm">UMKM</label>
                <div class="w-full border p-3 rounded flex items-center justify-between">
                    <div>{{ $produk->umkm->nama_usaha ?? 'UMKM tidak tersedia' }}</div>
                    <input type="hidden" name="umkm_id" value="{{ $produk->umkm_id }}">
                </div>

                <input type="text" name="nama_produk" placeholder="Nama Produk"
                    value="{{ old('nama_produk', $produk->nama_produk) }}" class="w-full border p-3 rounded" required>
                <textarea name="deskripsi" placeholder="Deskripsi" class="w-full border p-3 rounded">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                <input type="number" name="harga" placeholder="Harga" value="{{ old('harga', $produk->harga) }}"
                    class="w-full border p-3 rounded" required>
                <input type="number" name="stok" placeholder="Stok" value="{{ old('stok', $produk->stok) }}"
                    class="w-full border p-3 rounded" required>

                <div>
                    <label class="block text-sm font-medium mb-2">Gambar Utama Saat Ini</label>
                    @if ($produk->gambar_produk)
                        <img src="{{ asset('storage/' . $produk->gambar_produk) }}" alt="Gambar utama"
                            class="w-48 h-48 object-cover rounded">
                    @else
                        <div class="w-48 h-48 bg-gray-100 rounded flex items-center justify-center">Tidak ada gambar</div>
                    @endif
                </div>

                <div class="">
                    <label class="block text-sm font-medium mb-2">Gallery Gambar (hapus gambar yang tidak
                        diinginkan)</label>
                    <div class="grid grid-cols-3 gap-4 mb-4">
                        @foreach ($produk->images as $img)
                            <div class="relative border rounded overflow-hidden">
                                <img src="{{ asset('storage/' . $img->path) }}" alt="Gambar"
                                    class="w-full h-40 object-cover">
                                <form method="POST"
                                    action="{{ route('produk.images.destroy', ['produk' => $produk->produk_id, 'image' => $img->id]) }}"
                                    class="absolute top-2 right-2" onsubmit="return confirm('Hapus gambar ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-600 text-white px-2 py-1 rounded text-sm">Hapus</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div x-data="{
                    previews: [],
                    error: null,
                    maxBytes: 2048 * 1024,
                    handleFiles(e) {
                        this.previews = [];
                        this.error = null;
                        const files = e.target.files;
                        for (let i = 0; i < files.length; i++) {
                            const file = files[i];
                            if (file.size > this.maxBytes) { this.error = 'Satu atau lebih gambar melebihi 2MB dan diabaikan'; continue }
                            const reader = new FileReader();
                            reader.onload = (ev) => { this.previews.push({ name: file.name, src: ev.target.result }); };
                            reader.readAsDataURL(file);
                        }
                    },
                    clearSelection() {
                        this.previews = [];
                        $refs.fileInput.value = null
                    }
                }">
                    <label class="block text-sm font-medium mb-2">Tambahkan Gambar Baru (multiple)</label>
                    <input x-ref="fileInput" x-on:change="handleFiles" accept="image/*" type="file" name="images[]"
                        multiple class="w-full mb-2">
                    <p class="text-sm text-gray-500">Maksimal 2MB per file.</p>

                    <div class="flex gap-4 mb-2">
                        <template x-for="p in previews" :key="p.name">
                            <div class="w-32 h-32 border rounded overflow-hidden">
                                <img :src="p.src" class="w-full h-full object-cover">
                            </div>
                        </template>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="button" x-on:click="clearSelection" class="px-3 py-1 bg-gray-200 rounded">Clear
                            Selection</button>
                        <p class="text-sm text-gray-500">Preview gambar yang dipilih akan muncul di atas sebelum upload.</p>
                    </div>
                    <p x-text="error" x-show="error" class="text-red-600 text-sm mt-1"></p>
                </div>

                <div class="flex gap-2">
                    <button class="bg-green-600 text-white px-4 py-2 rounded">Simpan Perubahan</button>
                    <a href="{{ route('produk.index') }}" class="px-4 py-2 border rounded">Batal</a>
                </div>
            </div>
        </form>
    </div>
@endsection
