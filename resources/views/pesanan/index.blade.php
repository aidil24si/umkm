@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">Pesanan Saya</h2>

    @if($pesanans->isEmpty())
        <div class="text-gray-500">Belum ada pesanan.</div>
    @else
        <div class="space-y-4">
            @foreach($pesanans as $p)
                <div class="border p-4 rounded flex items-center justify-between">
                    <div>
                        <div class="font-bold">{{ $p->nomor_pesanan }}</div>
                        <div class="text-sm text-gray-500">Status: {{ $p->status }}</div>
                        <div class="text-sm text-gray-500">Total: Rp {{ number_format($p->total,0,',','.') }}</div>
                    </div>
                    <div>
                        <a href="{{ route('pesanan.show', $p->pesanan_id) }}" class="px-3 py-1 bg-blue-600 text-white rounded">Lihat</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection