@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-4">Tambah Produk</h2>

        <form method="POST" action="{{ route('produk.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-4">
                @if (isset($selectedUmkm) && $selectedUmkm)
                    <input type="hidden" name="umkm_id" value="{{ $selectedUmkm->umkm_id }}">
                    <div class="text-sm text-gray-700">UMKM: <strong>{{ $selectedUmkm->nama_usaha }}</strong></div>
                @else
                    <label class="text-sm">Pilih UMKM</label>
                    <select name="umkm_id" class="w-full border p-3 rounded" required>
                        <option value="">-- Pilih UMKM --</option>
                        @foreach ($umkms as $u)
                            <option value="{{ $u->umkm_id }}">{{ $u->nama_usaha }}</option>
                        @endforeach
                    </select>
                @endif

                <input type="text" name="nama_produk" placeholder="Nama Produk" value="{{ old('nama_produk') }}"
                    class="w-full border p-3 rounded" required>

                <div x-data="{
                    mainPreview: null,
                    previews: [],
                    error: null,
                    maxBytes: 2048 * 1024,
                    handleMain(e) {
                        const f = e.target.files[0];
                        if (!f) {
                            this.mainPreview = null;
                            this.error = null;
                            return
                        }
                        if (f.size > this.maxBytes) {
                            this.error = 'Gambar utama melebihi 2MB';
                            e.target.value = null;
                            this.mainPreview = null;
                            return
                        }
                        const r = new FileReader();
                        r.onload = ev => this.mainPreview = ev.target.result;
                        r.readAsDataURL(f);
                    },
                    handleFiles(e) {
                        this.previews = [];
                        this.error = null;
                        const files = e.target.files;
                        for (let i = 0; i < files.length; i++) {
                            const file = files[i];
                            if (file.size > this.maxBytes) { this.error = 'Satu atau lebih gambar galeri melebihi 2MB dan diabaikan'; continue }
                            const reader = new FileReader();
                            reader.onload = (ev) => { this.previews.push({ name: file.name, src: ev.target.result }); };
                            reader.readAsDataURL(file);
                        }
                    },
                    clearSelection(ref) { this.previews = []; if (ref) ref.value = null; },
                    clearMain(ref) { this.mainPreview = null; if (ref) ref.value = null }
                }">
                    <label class="block text-sm font-medium">Gambar Utama</label>
                    <input x-ref="mainInput" x-on:change="handleMain" accept="image/*" type="file" name="gambar_produk"
                        class="w-full mb-2">
                    <p class="text-sm text-gray-500">Maksimal 2MB per file.</p>

                    <div class="mb-4">
                        <template x-if="mainPreview">
                            <img :src="mainPreview" class="w-48 h-48 object-cover rounded" alt="Preview utama">
                        </template>
                        <template x-if="!mainPreview">
                            <div class="w-48 h-48 bg-gray-100 rounded flex items-center justify-center">Tidak ada gambar
                                utama</div>
                        </template>
                        <div class="mt-2">
                            <button type="button" x-on:click="clearMain($refs.mainInput)"
                                class="px-3 py-1 bg-gray-200 rounded">Clear Main</button>
                        </div>
                    </div>

                    <label class="block text-sm font-medium mt-2">Tambahkan Gambar Galeri (optional, multiple)</label>
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
                        <button type="button" x-on:click="clearSelection($refs.fileInput)"
                            class="px-3 py-1 bg-gray-200 rounded">Clear Selection</button>
                        <p class="text-sm text-gray-500">Preview gambar yang dipilih akan muncul di atas sebelum upload.</p>
                    </div>
                    <p x-text="error" x-show="error" class="text-red-600 text-sm mt-1"></p>
                </div>

                <textarea name="deskripsi" placeholder="Deskripsi" class="w-full border p-3 rounded">{{ old('deskripsi') }}</textarea>
                <input type="number" name="harga" placeholder="Harga" value="{{ old('harga') }}"
                    class="w-full border p-3 rounded" required>
                <input type="number" name="stok" placeholder="Stok" value="{{ old('stok', 1) }}"
                    class="w-full border p-3 rounded" required>

                <div class="flex gap-2">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan Produk</button>
                    <a href="{{ route('produk.index') }}" class="px-4 py-2 border rounded">Batal</a>
                </div>
            </div>
        </form>
    </div>
@endsection
