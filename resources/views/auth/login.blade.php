@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold mb-4">Masuk ke Etalase</h2>

    @if($errors->any())
        <div class="bg-red-50 text-red-700 p-3 rounded mb-4 border border-red-100">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ url('/login') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full border p-3 rounded-md focus:ring-2 focus:ring-blue-200" />
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" required class="w-full border p-3 rounded-md focus:ring-2 focus:ring-blue-200" />
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md shadow">Masuk</button>
            <a href="{{ route('register') }}" class="text-sm text-blue-600">Belum punya akun? Daftar</a>
        </div>
    </form>
</div>
@endsection
