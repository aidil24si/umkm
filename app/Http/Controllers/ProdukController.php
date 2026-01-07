<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Produk::query();
        $currentUmkm = null;
        if ($request->has('umkm')) {
            $currentUmkm = \App\Models\Umkm::find($request->get('umkm'));
            $query->where('umkm_id', $request->get('umkm'));
        }

        $produks = $query->latest()->paginate(12);
        return view('produk.index', compact('produks', 'currentUmkm'));
    }

    public function create(Request $request)
    {
        // If umkm_id is provided in query string, verify ownership and pass to view
        $selectedUmkm = null;
        if ($request->has('umkm_id')) {
            $selectedUmkm = \App\Models\Umkm::findOrFail($request->get('umkm_id'));
            if (auth()->id() !== $selectedUmkm->pemilik_warga_id && auth()->user()->role !== 'admin') {
                abort(403);
            }
        }

        // Tampilkan UMKM milik user untuk dihubungkan dengan produk
        $umkms = auth()->check() ? \App\Models\Umkm::where('pemilik_warga_id', auth()->id())->get() : collect();
        return view('produk.create', compact('umkms', 'selectedUmkm'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'umkm_id' => 'required|exists:umkm,umkm_id',
            'nama_produk' => 'required|string|max:255',
            'gambar_produk' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
        ]);

        if ($request->hasFile('gambar_produk')) {
            $data['gambar_produk'] = $request->file('gambar_produk')->store('produk', 'public');
        }

        // Ensure ownership: umkm must belong to the authenticated user unless admin
        $umkm = \App\Models\Umkm::findOrFail($data['umkm_id']);
        if (auth()->id() !== $umkm->pemilik_warga_id && auth()->user()->role !== 'admin') {
            abort(403);
        }

        // Remove files array from mass-assignment data to avoid trying to insert non-existing columns
        if (isset($data['images'])) {
            unset($data['images']);
        }

        $produk = \App\Models\Produk::create($data);

        // handle gallery (additional images)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $p = $file->store('produk', 'public');
                \App\Models\ProdukImage::create(['produk_id' => $produk->produk_id, 'path' => $p]);
            }
        }

        return redirect()->route('produk.index', ['umkm' => $produk->umkm_id])->with('success', 'Produk berhasil dibuat.');
    }

    public function show($id)
    {
        $produk = \App\Models\Produk::findOrFail($id);
        return view('produk.show', compact('produk'));
    }

    public function edit($id)
    {
        $produk = \App\Models\Produk::findOrFail($id);
        // pastikan yang edit adalah pemilik UMKM atau admin
        if (auth()->id() !== $produk->umkm->pemilik_warga_id && auth()->user()->role !== 'admin') {
            abort(403);
        }
        $umkms = \App\Models\Umkm::where('pemilik_warga_id', auth()->id())->get();
        return view('produk.edit', compact('produk', 'umkms'));
    }

    public function update(Request $request, $id)
    {
        $produk = \App\Models\Produk::findOrFail($id);
        if (auth()->id() !== $produk->umkm->pemilik_warga_id && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $data = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'gambar_produk' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
        ]);

        if ($request->hasFile('gambar_produk')) {
            $path = $request->file('gambar_produk')->store('produk', 'public');
            // hapus file lama
            if ($produk->gambar_produk && \Illuminate\Support\Facades\Storage::disk('public')->exists($produk->gambar_produk)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($produk->gambar_produk);
            }
            $data['gambar_produk'] = $path;
        }

        // Remove files array from mass-assignment data to avoid trying to insert non-existing columns
        if (isset($data['images'])) {
            unset($data['images']);
        }

        $produk->update($data);

        // handle additional gallery uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $p = $file->store('produk', 'public');
                \App\Models\ProdukImage::create(['produk_id' => $produk->produk_id, 'path' => $p]);
            }
        }

        return redirect()->route('produk.show', $produk->produk_id)->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $produk = \App\Models\Produk::findOrFail($id);
        if (auth()->id() !== $produk->umkm->pemilik_warga_id && auth()->user()->role !== 'admin') {
            abort(403);
        }

        if ($produk->gambar_produk && \Illuminate\Support\Facades\Storage::disk('public')->exists($produk->gambar_produk)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($produk->gambar_produk);
        }

        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }

    // delete product image
    public function destroyImage($produk_id, $image_id)
    {
        $produk = \App\Models\Produk::findOrFail($produk_id);
        $image = \App\Models\ProdukImage::where('produk_id', $produk->produk_id)->where('id', $image_id)->firstOrFail();

        if (auth()->id() !== $produk->umkm->pemilik_warga_id && auth()->user()->role !== 'admin') {
            abort(403);
        }

        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($image->path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($image->path);
        }

        $image->delete();

        return redirect()->back()->with('success', 'Gambar produk berhasil dihapus.');
    }

    // Bulk action for products (publish/unpublish)
    public function bulkAction(Request $request)
    {
        $data = $request->validate([
            'ids' => 'required|array',
            'action' => 'required|string|in:publish,unpublish',
        ]);

        $ids = $data['ids'];
        $action = $data['action'];

        $produkQuery = \App\Models\Produk::whereIn('produk_id', $ids);

        // ensure ownership for non-admins
        if (auth()->user()->role !== 'admin') {
            $ownedUmkmIds = \App\Models\Umkm::where('pemilik_warga_id', auth()->id())->pluck('umkm_id')->toArray();
            $produkQuery->whereIn('umkm_id', $ownedUmkmIds);
        }

        $status = $action === 'publish' ? 'tersedia' : 'arsip';
        $produkQuery->update(['status' => $status]);

        return redirect()->back()->with('success', 'Aksi bulk berhasil diterapkan.');
    }
}
