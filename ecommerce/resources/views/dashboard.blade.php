<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-navy-900">Dashboard</h1>
            <span class="text-xs font-semibold px-2.5 py-1 bg-slate-100 text-slate-700 rounded-md border border-slate-200 uppercase">
                {{ Auth::user()->role ?? 'Pembeli' }}
            </span>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Welcoming Section -->
        <div class="bg-white border border-slate-200 rounded-xl p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-navy-900">Halo, {{ Auth::user()->name }}</h2>
                <p class="text-xs text-slate-500 mt-0.5">
                    @if(Auth::user()->role === 'admin')
                        Kelola katalog produk, kategori, dan pesanan masuk dari pembeli.
                    @else
                        Pantau status transaksi dan riwayat belanja kamu.
                    @endif
                </p>
            </div>
            <div class="flex gap-2">
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-navy-900 hover:bg-navy-800 text-white text-xs font-semibold rounded-lg transition">
                        Kelola Pesanan
                    </a>
                    <a href="{{ route('products.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg border border-slate-200 transition">
                        Produk
                    </a>
                @else
                    <a href="{{ url('/') }}" class="px-4 py-2 bg-navy-900 hover:bg-navy-800 text-white text-xs font-semibold rounded-lg transition">
                        Ke Etalase
                    </a>
                    <a href="{{ route('orders.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg border border-slate-200 transition">
                        Pesanan Saya
                    </a>
                @endif
            </div>
        </div>

        <!-- Shortcut Navigation -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('products.index') }}" class="bg-white border border-slate-200 rounded-xl p-5 hover:border-navy-900 transition">
                    <div class="text-navy-900 mb-2">
                        <i class="fa-solid fa-boxes-stacked text-base"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900">Kelola Produk</h3>
                    <p class="text-xs text-slate-500 mt-1">Tambah, ubah, atau atur persediaan barang.</p>
                </a>

                <a href="{{ route('categories.index') }}" class="bg-white border border-slate-200 rounded-xl p-5 hover:border-navy-900 transition">
                    <div class="text-navy-900 mb-2">
                        <i class="fa-solid fa-tags text-base"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900">Kategori</h3>
                    <p class="text-xs text-slate-500 mt-1">Pengelompokan jenis produk toko.</p>
                </a>

                <a href="{{ route('admin.orders.index') }}" class="bg-white border border-slate-200 rounded-xl p-5 hover:border-navy-900 transition">
                    <div class="text-navy-900 mb-2">
                        <i class="fa-solid fa-receipt text-base"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900">Daftar Pesanan</h3>
                    <p class="text-xs text-slate-500 mt-1">Lihat dan ubah status transaksi pembeli.</p>
                </a>
            @else
                <a href="{{ url('/') }}" class="bg-white border border-slate-200 rounded-xl p-5 hover:border-navy-900 transition">
                    <div class="text-navy-900 mb-2">
                        <i class="fa-solid fa-store text-base"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900">Etalase Toko</h3>
                    <p class="text-xs text-slate-500 mt-1">Cari produk dan lakukan pembelian.</p>
                </a>

                <a href="{{ route('orders.index') }}" class="bg-white border border-slate-200 rounded-xl p-5 hover:border-navy-900 transition">
                    <div class="text-navy-900 mb-2">
                        <i class="fa-solid fa-bag-shopping text-base"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900">Pesanan Saya</h3>
                    <p class="text-xs text-slate-500 mt-1">Cek riwayat dan status pengiriman barang.</p>
                </a>

                <a href="{{ route('profile.edit') }}" class="bg-white border border-slate-200 rounded-xl p-5 hover:border-navy-900 transition">
                    <div class="text-navy-900 mb-2">
                        <i class="fa-solid fa-user-gear text-base"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900">Pengaturan Akun</h3>
                    <p class="text-xs text-slate-500 mt-1">Ubah kata sandi dan profil pengguna.</p>
                </a>
            @endif
        </div>
    </div>
</x-app-layout>