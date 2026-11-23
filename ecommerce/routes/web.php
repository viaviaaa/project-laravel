<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Etalase Utama (Pencarian & Filter Kategori)
Route::get('/', function (Request $request) {
    $search = $request->query('search');
    $categoryId = $request->query('category_id');

    $products = Product::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })
        ->when($categoryId, function ($query, $categoryId) {
            return $query->where('category_id', $categoryId);
        })
        ->with('category')
        ->latest()
        ->get();

    $categories = Category::all();

    return view('welcome', compact('products', 'categories', 'search', 'categoryId'));
});

// 2. Autentikasi Pembeli (Profile, Pesanan Saya, & Checkout)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
});

// 3. Khusus Admin (Kelola Produk, Kategori, & Pesanan Pembeli)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);

    Route::get('/admin/orders', [OrderController::class, 'adminIndex'])->name('admin.orders.index');
    Route::patch('/admin/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
});

// 4. Route Instan Ubah Akun Jadi Admin
Route::get('/jadi-admin', function () {
    if (!Auth::check()) {
        return "Kamu belum login! Login dulu di <a href='/login'>halaman login</a> baru akses URL ini lagi.";
    }

    DB::table('users')->where('id', Auth::id())->update(['role' => 'admin']);

    return "<h1>BERHASIL! 🎉</h1><p>Akun <b>" . Auth::user()->email . "</b> sekarang resmi jadi <b>ADMIN</b>!</p><a href='/dashboard' style='padding:10px 15px; background:#253C6D; color:white; text-decoration:none; border-radius:8px;'>Ke Dashboard Admin</a>";
})->middleware('auth');

require __DIR__.'/auth.php';

// 5. Dashboard Otomatis Sesuai Role
Route::get('/dashboard', function () {
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.orders.index');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');