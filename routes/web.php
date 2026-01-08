<?php
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UasController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PesananController;

Route::get('/', [UmkmController::class, 'index'])->name('umkm.index');
// Show UMKM details (only numeric IDs) to avoid catching 'create' as an id
Route::get('/umkm/{id}', [UmkmController::class, 'show'])->whereNumber('id')->name('umkm.show');

// Minimal Auth Routes (login/register/logout)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended(route('umkm.index'));
    }

    return back()->withErrors(['email' => 'Email atau password salah'])->onlyInput('email');
});

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function (Request $request) {
    $data = $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed|min:6',
    ]);

    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
    ]);

    Auth::login($user);

    return redirect()->route('umkm.index');
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('umkm.index');
})->name('logout');

// Group untuk User yang Login
Route::middleware(['auth'])->group(function () {
    // Daftar Usaha (manage own UMKM)
    Route::get('/umkm/daftar', [UmkmController::class, 'myIndex'])->name('umkm.daftar');

    Route::resource('umkm', UmkmController::class)->except(['index', 'show']);

    // CRUD Produk
    Route::resource('produk', ProdukController::class);

    // delete product image
    Route::delete('/produk/{produk}/images/{image}', [ProdukController::class, 'destroyImage'])->name('produk.images.destroy');

    // Bulk products action
    Route::post('/produk/bulk', [ProdukController::class, 'bulkAction'])->name('produk.bulk');

    // Pesanan & Checkout
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{pesanan}', [PesananController::class, 'show'])->name('pesanan.show');
    Route::post('/pesanan/quick/{produk}', [PesananController::class, 'quickCreate'])->name('pesanan.quick');
    Route::post('/checkout', [PesananController::class, 'store'])->name('checkout');

    // Profile management (user)
    Route::get('/profile/edit', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    // Admin site settings
    Route::middleware('admin')->prefix('admin')->group(function(){
        Route::get('/settings', [\App\Http\Controllers\AdminSettingsController::class, 'edit'])->name('admin.settings');
        Route::post('/settings/logo', [\App\Http\Controllers\AdminSettingsController::class, 'updateLogo'])->name('admin.settings.logo');
        Route::post('/settings/logo-from-umkm/{umkm}', [\App\Http\Controllers\AdminSettingsController::class, 'setLogoFromUmkm'])->name('admin.settings.logo.from_umkm');
        Route::post('/settings/logo-delete', [\App\Http\Controllers\AdminSettingsController::class, 'deleteLogo'])->name('admin.settings.logo.delete');
    });
});

// Group Khusus Admin (Middleware Buatan Sendiri)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('users', AdminController::class); // CRUD User
});

Route::get('/uas/{param1}', [UasController::class, 'show']);

