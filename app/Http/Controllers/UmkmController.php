<?php
namespace App\Http\Controllers;

use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UmkmController extends Controller
{
    // Menampilkan daftar UMKM (Public View)
    public function index()
    {
        // Pagination included
        $umkms = Umkm::latest()->paginate(9); 
        return view('umkm.index', compact('umkms'));
    }

    // Daftar UMKM milik user (CRUD management) with search & pagination
    public function myIndex(Request $request)
    {
        $query = Umkm::where('pemilik_warga_id', auth()->id());

        if ($request->filled('q')) {
            $q = $request->get('q');
            $query->where(function($sub) use ($q) {
                $sub->where('nama_usaha', 'like', "%$q%")
                    ->orWhere('kategori', 'like', "%$q%")
                    ->orWhere('kontak', 'like', "%$q%");
            });
        }

        $umkms = $query->latest()->paginate(10)->withQueryString();
        return view('umkm.daftar', compact('umkms'));
    }

    // Form Tambah (Hanya jika login)
    public function create()
    {
        return view('umkm.create');
    }

    // Store Data (CRUD - Create)
    public function store(Request $request)
    {
        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'gambar_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'kategori' => 'required|string|max:100',
            'kontak' => 'required|string|max:100',
            'alamat' => 'required|string',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'deskripsi' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['pemilik_warga_id'] = auth()->id(); // Otomatis ambil user login

        if ($request->hasFile('gambar_logo')) {
            $path = $request->file('gambar_logo')->store('logos', 'public');
            $data['gambar_logo'] = $path;
        }

        $umkm = Umkm::create($data);

        // Handle gallery images (multiple)
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $p = $file->store('umkm', 'public');
                \App\Models\UmkmImage::create(['umkm_id' => $umkm->umkm_id, 'path' => $p]);
            }
        }

        // Redirect ke daftar usaha milik user dengan pesan sukses
        return redirect()->route('umkm.daftar')->with('success', 'UMKM berhasil dibuka!');
    }

    // Show Detail
    public function show($id)
    {
        $umkm = Umkm::with('produk')->findOrFail($id);
        return view('umkm.show', compact('umkm'));
    }

    // Edit form
    public function edit($umkm_id)
    {
        $umkm = Umkm::findOrFail($umkm_id);
        // Pastikan hanya pemilik atau admin yang bisa edit
        if (auth()->id() !== $umkm->pemilik_warga_id && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        return view('umkm.edit', compact('umkm'));
    }

    // Update data
    public function update(Request $request, $umkm_id)
    {
        $umkm = Umkm::findOrFail($umkm_id);
        if (auth()->id() !== $umkm->pemilik_warga_id && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'gambar_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'kategori' => 'required|string|max:100',
            'alamat' => 'required|string',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'kontak' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        if ($request->hasFile('gambar_logo')) {
            $path = $request->file('gambar_logo')->store('logos', 'public');
            $data['gambar_logo'] = $path;
        }

        $umkm->update($data);

        // Handle additional gallery uploads
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $p = $file->store('umkm', 'public');
                \App\Models\UmkmImage::create(['umkm_id' => $umkm->umkm_id, 'path' => $p]);
            }
        }

        return redirect()->route('umkm.daftar')->with('success', 'UMKM berhasil diperbarui.');
    }

    // Delete
    public function destroy($umkm_id)
    {
        $umkm = Umkm::findOrFail($umkm_id);
        if (auth()->id() !== $umkm->pemilik_warga_id && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        // Hapus file logo jika ada
        if ($umkm->gambar_logo && \Illuminate\Support\Facades\Storage::disk('public')->exists($umkm->gambar_logo)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($umkm->gambar_logo);
        }

        $umkm->delete();

        return redirect()->route('umkm.daftar')->with('success', 'UMKM berhasil dihapus.');
    }

    // Delete an image from gallery
    public function destroyImage($umkm_id, $image_id)
    {
        $umkm = Umkm::findOrFail($umkm_id);
        $image = \App\Models\UmkmImage::where('umkm_id', $umkm->umkm_id)->where('id', $image_id)->firstOrFail();

        if (auth()->id() !== $umkm->pemilik_warga_id && auth()->user()->role !== 'admin') {
            abort(403);
        }

        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($image->path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($image->path);
        }

        $image->delete();

        return redirect()->back()->with('success', 'Gambar berhasil dihapus.');
    }
}

