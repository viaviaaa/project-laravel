<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-extrabold text-2xl text-navy-900 leading-tight flex items-center gap-2.5">
                    <i class="fa-solid fa-square-plus text-navy-700"></i> Tambah Produk Baru
                </h2>
                <p class="text-xs text-slate-500 mt-1 font-semibold">Isi formulir berikut untuk memasukkan barang baru ke etalase toko.</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-xs font-bold text-slate-600 hover:text-navy-900 bg-white border border-slate-200 px-4 py-2.5 rounded-2xl shadow-sm transition flex items-center gap-1.5 active:scale-95">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Gudang
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Nama & Kategori -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-extrabold text-xs uppercase tracking-wider text-navy-900 mb-2">Nama Produk</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-800 focus:bg-white focus:border-navy-900 focus:ring-4 focus:ring-navy-900/10 focus:outline-none transition" placeholder="Misal: Kemeja Flanel Navy" required>
                    @error('name')
                        <p class="text-rose-500 text-xs mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-extrabold text-xs uppercase tracking-wider text-navy-900 mb-2">Koleksi Kategori</label>
                    <select name="category_id" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-800 focus:bg-white focus:border-navy-900 focus:ring-4 focus:ring-navy-900/10 focus:outline-none transition" required>
                        <option value="">-- Pilih Koleksi --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-rose-500 text-xs mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Harga & Stok -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-extrabold text-xs uppercase tracking-wider text-navy-900 mb-2">Harga (Rp)</label>
                    <input type="number" name="price" value="{{ old('price') }}" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-800 focus:bg-white focus:border-navy-900 focus:ring-4 focus:ring-navy-900/10 focus:outline-none transition" placeholder="75000" min="0" required>
                    @error('price')
                        <p class="text-rose-500 text-xs mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-extrabold text-xs uppercase tracking-wider text-navy-900 mb-2">Stok Barang</label>
                    <input type="number" name="stock" value="{{ old('stock') }}" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-800 focus:bg-white focus:border-navy-900 focus:ring-4 focus:ring-navy-900/10 focus:outline-none transition" placeholder="50" min="0" required>
                    @error('stock')
                        <p class="text-rose-500 text-xs mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Upload Foto Produk -->
            <div>
                <label class="block font-extrabold text-xs uppercase tracking-wider text-navy-900 mb-2">Foto Produk</label>
                <input type="file" name="image" accept="image/*" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-navy-900 file:text-white hover:file:bg-navy-800 transition cursor-pointer">
                @error('image')
                    <p class="text-rose-500 text-xs mt-1.5 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Simpan -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('products.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 px-5 py-3 rounded-2xl transition">Batal</a>
                <button type="submit" class="bg-navy-900 hover:bg-navy-800 text-white text-xs font-extrabold px-6 py-3.5 rounded-2xl shadow-lg shadow-navy-900/20 transition active:scale-95 flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Produk
                </button>
            </div>
        </form>
    </div>
</x-app-layout>