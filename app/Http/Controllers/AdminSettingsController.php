<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSettingsController extends Controller
{
    public function edit()
    {
        // only admin middleware group protects this route in routes
        $logoPath = null;
        if (Storage::disk('public')->exists('site/logo.png')) {
            $logoPath = 'site/logo.png';
        }
        return view('admin.settings', compact('logoPath'));
    }

    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:png,jpg,jpeg|max:4096',
        ]);

        // store as fixed filename so views can reference it easily
        $file = $request->file('logo');
        $path = $file->storeAs('site', 'logo.png', 'public');

        return redirect()->back()->with('success', 'Logo situs berhasil diperbarui.');
    }

    // set site logo from an existing UMKM logo
    public function setLogoFromUmkm($umkm_id)
    {
        $umkm = \App\Models\Umkm::findOrFail($umkm_id);
        if (! $umkm->gambar_logo || ! Storage::disk('public')->exists($umkm->gambar_logo)) {
            return redirect()->back()->with('error', 'UMKM tidak memiliki logo yang valid.');
        }

        // copy the UMKM logo to the site/logo.png path
        Storage::disk('public')->copy($umkm->gambar_logo, 'site/logo.png');

        return redirect()->back()->with('success', 'Logo situs diubah dari logo UMKM.');
    }

    // delete current site logo
    public function deleteLogo()
    {
        if (Storage::disk('public')->exists('site/logo.png')) {
            Storage::disk('public')->delete('site/logo.png');
        }
        return redirect()->back()->with('success', 'Logo situs dihapus.');
    }
}
