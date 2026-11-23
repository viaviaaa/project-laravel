<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-extrabold text-2xl text-navy-900 leading-tight flex items-center gap-2.5">
                    <i class="fa-solid fa-boxes-stacked text-navy-700"></i> Gudang Barang (Manajemen Produk)
                </h2>
                <p class="text-xs text-slate-500 mt-1 font-semibold">Kelola daftar stok, harga, dan foto produk toko kamu di sini.</p>
            </div>
            <a href="{{ route('products.create') }}" class="bg-navy-900 hover:bg-navy-800 text-white font-bold text-xs px-5 py-3 rounded-2xl shadow-lg shadow-navy-900/20 transition flex items-center gap-2 self-start sm:self-auto active:scale-95">
                <i class="fa-solid fa-plus text-sm"></i> Tambah Produk Baru
            </a>
        </div>
    </x-slot>

    <!-- Notifikasi Berhasil (Flash Message) -->
    @if (session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl flex items-center justify-between text-xs font-bold shadow-sm">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>
    @endif

    <!-- TABEL MANAJEMEN PRODUK FULL WIDTH -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-[11px] uppercase tracking-wider font-extrabold">
                        <th class="py-4 px-6">Foto</th>
                        <th class="py-4 px-6">Nama Produk</th>
                        <th class="py-4 px-6">Kategori</th>
                        <th class="py-4 px-6">Harga</th>
                        <th class="py-4 px-6">Stok</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse ($products as $product)
                        <tr class="hover:bg-slate-50/80 transition">
                            <!-- Foto Produk -->
                            <td class="py-4 px-6">
                                <div class="w-14 h-14 bg-slate-100 rounded-2xl overflow-hidden border border-slate-200 flex items-center justify-center shrink-0">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover" alt="{{ $product->name }}">
                                    @else
                                        <i class="fa-regular fa-image text-slate-400 text-xl"></i>
                                    @endif
                                </div>
                            </td>

                            <!-- Nama Produk -->
                            <td class="py-4 px-6 font-bold text-navy-900">
                                {{ $product->name }}
                            </td>

                            <!-- Kategori -->
                            <td class="py-4 px-6">
                                <span class="text-[10px] font-extrabold bg-navy-700/10 text-navy-800 px-2.5 py-1 rounded-lg uppercase tracking-wider border border-navy-700/20">
                                    {{ $product->category->name ?? 'Umum' }}
                                </span>
                            </td>

                            <!-- Harga -->
                            <td class="py-4 px-6 font-extrabold text-navy-900">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>

                            <!-- Stok Barang -->
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $product->stock > 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                                    <span class="w-2 h-2 rounded-full {{ $product->stock > 0 ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                    {{ $product->stock }} Pcs
                                </span>
                            </td>

                            <!-- Tombol Aksi -->
                            <td class="py-4 px-6">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('products.edit', $product->id) }}" class="bg-slate-100 hover:bg-navy-900 hover:text-white text-navy-900 w-9 h-9 rounded-xl flex items-center justify-center transition border border-slate-200 shadow-sm active:scale-95" title="Edit Produk">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>

                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah kamu yakin ingin menghapus produk ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-rose-50 hover:bg-rose-600 hover:text-white text-rose-600 w-9 h-9 rounded-xl flex items-center justify-center transition border border-rose-200 shadow-sm active:scale-95" title="Hapus Produk">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fa-solid fa-box-open text-4xl text-navy-700/30 mb-3"></i>
                                    <h3 class="font-bold text-navy-900 text-base">Gudang Masih Kosong</h3>
                                    <p class="text-xs text-slate-400 mt-1 mb-4 font-semibold">Belum ada produk yang ditambahkan ke database.</p>
                                    <a href="{{ route('products.create') }}" class="bg-navy-900 text-white font-bold text-xs px-4 py-2.5 rounded-xl hover:bg-navy-800 transition">
                                        + Tambah Produk Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-navy-900 leading-tight flex items-center gap-2.5">
                    <i class="fa-solid fa-boxes-stacked text-navy-700"></i> Gudang Barang (Manajemen Produk)
                </h2>
                <p class="text-xs text-slate-500 mt-1 font-semibold">Kelola seluruh persediaan stok, penetapan harga, dan media foto toko.</p>
            </div>
            <a href="{{ route('products.create') }}" class="bg-navy-900 hover:bg-navy-800 text-white font-extrabold text-xs px-5 py-3 rounded-2xl shadow-lg shadow-navy-900/20 transition flex items-center gap-2 self-start sm:self-auto active:scale-95">
                <i class="fa-solid fa-plus text-sm"></i> Tambah Produk Baru
            </a>
        </div>
    </x-slot>

    <!-- NOTIFIKASI SUKSES -->
    @if (session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl flex items-center justify-between text-xs font-bold shadow-sm">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>
    @endif

    <!-- KARTU RINGKASAN KPI DASHBOARD -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        
        <!-- KPI 1: Total Jenis Barang -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider block">Total Jenis Barang</span>
                <span class="text-2xl font-black text-navy-900 mt-1 block">{{ $products->count() }} Item</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-navy-900/10 text-navy-900 flex items-center justify-center font-black text-lg">
                <i class="fa-solid fa-box-archive"></i>
            </div>
        </div>

        <!-- KPI 2: Total Unit Stok -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider block">Total Unit Stok</span>
                <span class="text-2xl font-black text-emerald-600 mt-1 block">{{ $products->sum('stock') }} Pcs</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-black text-lg border border-emerald-100">
                <i class="fa-solid fa-cubes"></i>
            </div>
        </div>

        <!-- KPI 3: Estimasi Valuasi -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider block">Estimasi Valuasi</span>
                <span class="text-xl font-black text-navy-900 mt-1 block">
                    Rp {{ number_format($products->sum(function($p){ return $p->price * $p->stock; }), 0, ',', '.') }}
                </span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center font-black text-lg border border-amber-100">
                <i class="fa-solid fa-sack-dollar"></i>
            </div>
        </div>

        <!-- KPI 4: Stok Kritis -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider block">Stok Kritis (&le; 5)</span>
                <span class="text-2xl font-black text-rose-600 mt-1 block">
                    {{ $products->where('stock', '<=', 5)->count() }} Item
                </span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center font-black text-lg border border-rose-100">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
        </div>

    </div>

    <!-- TABEL Inventaris PRODUK -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/50">
            <h3 class="font-extrabold text-navy-900 text-base">Daftar Inventaris Produk</h3>
            <div class="text-xs text-slate-400 font-semibold">
                Terakhir diperbarui: {{ date('d M Y, H:i') }} WIB
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-[11px] uppercase tracking-wider font-extrabold">
                        <th class="py-4 px-6">Foto</th>
                        <th class="py-4 px-6">Nama Produk</th>
                        <th class="py-4 px-6">Kategori</th>
                        <th class="py-4 px-6">Harga</th>
                        <th class="py-4 px-6">Stok Status</th>
                        <th class="py-4 px-6 text-center">Aksi Manajemen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse ($products as $product)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-6">
                                <div class="w-14 h-14 bg-slate-100 rounded-2xl overflow-hidden border border-slate-200 flex items-center justify-center shrink-0">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover" alt="{{ $product->name }}">
                                    @else
                                        <i class="fa-regular fa-image text-slate-400 text-xl"></i>
                                    @endif
                                </div>
                            </td>

                            <td class="py-4 px-6 font-extrabold text-navy-900">
                                {{ $product->name }}
                            </td>

                            <td class="py-4 px-6">
                                <span class="text-[10px] font-black bg-navy-700/10 text-navy-800 px-2.5 py-1 rounded-lg uppercase tracking-wider border border-navy-700/20">
                                    {{ $product->category->name ?? 'Umum' }}
                                </span>
                            </td>

                            <td class="py-4 px-6 font-black text-navy-900">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>

                            <td class="py-4 px-6">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $product->stock > 5 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($product->stock > 0 ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-rose-50 text-rose-700 border border-rose-200') }}">
                                    <span class="w-2 h-2 rounded-full {{ $product->stock > 5 ? 'bg-emerald-500' : ($product->stock > 0 ? 'bg-amber-500' : 'bg-rose-500') }}"></span>
                                    {{ $product->stock }} Pcs
                                </span>
                            </td>

                            <td class="py-4 px-6">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('products.edit', $product->id) }}" class="bg-slate-100 hover:bg-navy-900 hover:text-white text-navy-900 w-9 h-9 rounded-xl flex items-center justify-center transition border border-slate-200 shadow-sm active:scale-95" title="Edit Produk">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>

                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini secara permanen?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-rose-50 hover:bg-rose-600 hover:text-white text-rose-600 w-9 h-9 rounded-xl flex items-center justify-center transition border border-rose-200 shadow-sm active:scale-95" title="Hapus Produk">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fa-solid fa-box-open text-4xl text-navy-700/30 mb-3"></i>
                                    <h3 class="font-bold text-navy-900 text-base">Gudang Masih Kosong</h3>
                                    <p class="text-xs text-slate-400 mt-1 mb-4 font-semibold">Belum ada barang yang diinput.</p>
                                    <a href="{{ route('products.create') }}" class="bg-navy-900 text-white font-bold text-xs px-4 py-2.5 rounded-xl hover:bg-navy-800 transition">
                                        + Tambah Produk Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>