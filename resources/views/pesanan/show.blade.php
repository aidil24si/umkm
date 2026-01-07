@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">Detail Pesanan</h2>

    <div class="mb-4">
        <div class="font-bold">{{ $pesanan->nomor_pesanan }}</div>
        <div class="text-sm text-gray-500">Status: {{ $pesanan->status }}</div>
        <div class="text-sm text-gray-500">Total: Rp {{ number_format($pesanan->total,0,',','.') }}</div>
    </div>

    <div class="border rounded p-4">
        <h3 class="font-semibold mb-2">Item</h3>
        @foreach($pesanan->details as $d)
            <div class="flex items-center justify-between py-2 border-b last:border-b-0">
                <div>
                    <div class="font-medium">{{ $d->produk->nama_produk ?? 'Produk terhapus' }}</div>
                    <div class="text-sm text-gray-500">Qty: {{ $d->qty }} &middot; Harga: Rp {{ number_format($d->harga_satuan,0,',','.') }}</div>
                </div>
                <div class="font-semibold">Rp {{ number_format($d->subtotal,0,',','.') }}</div>
            </div>
        @endforeach
    </div>
</div>
@endsection