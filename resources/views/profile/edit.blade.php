@extends('layouts.app')

@section('content')
    <div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Edit Profil</h2>

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-4">
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="border p-3 rounded"
                    required>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="border p-3 rounded"
                    required>

                <div x-data="{ preview: null, error: null, maxBytes: 2048 * 1024, handle(e) { const f = e.target.files[0]; if (!f) { this.preview = null;
                            this.error = null; return } if (f.size > this.maxBytes) { this.error = 'Ukuran file melebihi 2MB';
                            e.target.value = null;
                            this.preview = null; return } const r = new FileReader();
                        r.onload = ev => this.preview = ev.target.result;
                        r.readAsDataURL(f); } }">
                    <label class="text-sm font-medium">Avatar (maks 2MB)</label>
                    <input x-on:change="handle" accept="image/*" type="file" name="avatar"
                        class="border p-2 rounded mb-2">

                    <div class="flex items-center gap-3">
                        <template x-if="preview">
                            <img :src="preview" class="w-16 h-16 object-cover rounded-full">
                        </template>

                        @if ($user->avatar && !old('avatar'))
                            <img src="{{ asset('storage/' . $user->avatar) }}" class="w-16 h-16 object-cover rounded-full">
                        @endif
                    </div>

                    <p x-text="error" x-show="error" class="text-red-600 text-sm mt-2"></p>
                </div>

                <div class="flex gap-2">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                    <a href="{{ route('umkm.index') }}" class="px-4 py-2 border rounded">Batal</a>
                </div>
            </div>
        </form>
    </div>
@endsection
