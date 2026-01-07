<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PesananController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function index()
    {
        $pesanans = \App\Models\Pesanan::where('warga_id', auth()->id())->latest()->get();
        return view('pesanan.index', compact('pesanans'));
    }

    public function show($id)
    {
        $pesanan = \App\Models\Pesanan::with('details.produk')->where('warga_id', auth()->id())->findOrFail($id);
        return view('pesanan.show', compact('pesanan'));
    }

    public function quickCreate(Request $request, $produk_id)
    {
        $request->validate([
            'qty' => 'nullable|integer|min:1',
        ]);

        $qty = $request->input('qty', 1);
        $produk = \App\Models\Produk::findOrFail($produk_id);

        if ($produk->status !== 'tersedia' || $produk->stok < $qty) {
            return redirect()->back()->withErrors(['stok' => 'Produk tidak tersedia atau stok tidak mencukupi.']);
        }

        $user = auth()->user();

        $nomor = 'P' . time() . rand(100,999);
        $total = $produk->harga * $qty;

        $pesanan = \App\Models\Pesanan::create([
            'nomor_pesanan' => $nomor,
            'warga_id' => $user->id,
            'total' => $total,
            'status' => 'pending',
            'alamat_kirim' => $user->alamat ?? '-',
            'rt' => $user->rt ?? '-',
            'rw' => $user->rw ?? '-',
            'metode_bayar' => 'cod',
        ]);

        \App\Models\DetailPesanan::create([
            'pesanan_id' => $pesanan->pesanan_id,
            'produk_id' => $produk->produk_id,
            'qty' => $qty,
            'harga_satuan' => $produk->harga,
            'subtotal' => $total,
        ]);

        // kurangi stok
        $produk->stok = max(0, $produk->stok - $qty);
        $produk->save();

        return redirect()->route('pesanan.show', $pesanan->pesanan_id)->with('success', 'Pesanan berhasil dibuat.');
    }

    public function store(Request $request)
    {
        // TODO: Implement checkout logic (validate, create order, charge, etc.)
        // For now return a simple redirect with a flash message.
        return redirect()->back()->with('success', 'Pesanan berhasil dibuat.');
    }
}
