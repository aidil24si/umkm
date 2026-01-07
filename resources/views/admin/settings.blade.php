@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Pengaturan Situs</h2>

        <form method="POST" action="{{ route('admin.settings.logo') }}" enctype="multipart/form-data" x-data="{ preview: null, error: null, maxBytes: 4096 * 1024, handle(e) { const f = e.target.files[0]; if (!f) { this.preview = null;
                    this.error = null; return } if (f.size > this.maxBytes) { this.error = 'Ukuran file melebihi 4MB';
                    e.target.value = null;
                    this.preview = null; return } const r = new FileReader();
                r.onload = ev => this.preview = ev.target.result;
                r.readAsDataURL(f); } }">
            @csrf
            <div class="grid gap-4">
                <label class="text-sm font-medium">Logo Situs (PNG disarankan, maks 4MB)</label>
                <input x-on:change="handle" accept="image/*" type="file" name="logo" class="border p-2 rounded">
                <p x-text="error" x-show="error" class="text-red-600 text-sm mt-1"></p>

                <div class="mt-2 flex items-center gap-3">
                    <template x-if="preview">
                        <img :src="preview" class="w-24 h-24 object-cover rounded-full" alt="preview logo">
                    </template>

                    @if ($logoPath)
                        <img src="{{ asset('storage/' . $logoPath) }}" class="w-24 h-24 object-cover rounded-full"
                            alt="site logo">
                    @endif

                    @if ($logoPath)
                        <form method="POST" action="{{ route('admin.settings.logo.delete') }}"
                            onsubmit="return confirm('Hapus logo situs?');">
                            @csrf
                            <button class="bg-red-600 text-white px-3 py-1 rounded">Hapus Logo</button>
                        </form>
                    @endif
                </div>

                <div class="flex gap-2">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded">Unggah Logo</button>
                    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 border rounded">Batal</a>
                </div>
            </div>
        </form>
    </div>
@endsection
