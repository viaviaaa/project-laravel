<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Via Store - Etalase Toko</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            800: '#1e325c',
                            900: '#253C6D',
                        }
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">

    <!-- Header Navbar -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
            
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-navy-900 text-amber-400 font-black text-xs rounded-lg flex items-center justify-center tracking-wider shadow-sm">
                    VS
                </div>
                <span class="font-black text-lg text-navy-900 tracking-tight">
                    Via<span class="text-amber-500">Store</span>
                </span>
            </a>

            <!-- Right Nav / Auth Links -->
            <div class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-3.5 py-1.5 bg-navy-900 hover:bg-navy-800 text-white text-xs font-semibold rounded-lg transition">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-xs font-semibold text-slate-600 hover:text-navy-900 px-2 py-1">
                            Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-3.5 py-1.5 bg-navy-900 hover:bg-navy-800 text-white text-xs font-semibold rounded-lg transition">
                                Daftar
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 flex-grow space-y-6">
        
        <!-- Filter & Search Bar -->
        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
            <form action="{{ url('/') }}" method="GET" class="flex flex-col sm:flex-row gap-3 items-center justify-between">
                <!-- Search Input -->
                <div class="relative w-full sm:w-80">
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama produk..." 
                           class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs font-medium focus:outline-none focus:border-navy-900 focus:bg-white transition" />
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-xs text-slate-400"></i>
                </div>

                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <!-- Category Select -->
                    <select name="category_id" onchange="this.form.submit()" class="w-full sm:w-auto px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs font-medium text-slate-700 focus:outline-none focus:border-navy-900 transition">
                        <option value="">Semua Kategori</option>
                        @foreach($categories ?? [] as $cat)
                            <option value="{{ $cat->id }}" {{ (isset($categoryId) && $categoryId == $cat->id) ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="px-4 py-2 bg-navy-900 hover:bg-navy-800 text-white text-xs font-semibold rounded-lg transition whitespace-nowrap">
                        Cari
                    </button>
                    
                    @if(!empty($search) || !empty($categoryId))
                        <a href="{{ url('/') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-lg transition">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Section Header -->
        <div class="flex items-center justify-between">
            <h1 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Katalog Produk</h1>
            <span class="text-xs font-semibold text-slate-400">
                {{ count($products ?? []) }} Produk Ditemukan
            </span>
        </div>

        <!-- Product Grid Dynamic Loop -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @forelse ($products ?? [] as $product)
                <div class="bg-white border border-slate-200 rounded-xl overflow-hidden flex flex-col hover:border-navy-900 transition duration-150 shadow-sm">
                    
                    <!-- Gambar Produk -->
                    <div class="aspect-square bg-slate-100 relative overflow-hidden border-b border-slate-100">
                        @if(!empty($product->image))
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 text-xs font-medium">
                                <i class="fa-solid fa-image text-2xl text-slate-300 mb-1"></i>
                                <span>Tidak Ada Gambar</span>
                            </div>
                        @endif
                    </div>

                    <!-- Informasi Produk -->
                    <div class="p-3.5 flex-1 flex flex-col justify-between space-y-3">
                        <div>
                            @if(isset($product->category))
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-0.5">
                                    {{ $product->category->name }}
                                </span>
                            @endif
                            <h3 class="text-xs font-bold text-slate-800 line-clamp-2 leading-snug">
                                {{ $product->name }}
                            </h3>
                        </div>

                        <div class="pt-2 border-t border-slate-100 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] text-slate-400 block font-medium">Harga</span>
                                <span class="text-xs font-bold text-navy-900">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            </div>

                            @auth
                                <form action="{{ route('checkout.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="total_price" value="{{ $product->price }}">
                                    <input type="hidden" name="payment_method" value="Transfer Bank">
                                    <input type="hidden" name="shipping_address" value="Alamat Pembeli">
                                    <button type="submit" class="px-3 py-1.5 bg-navy-900 hover:bg-navy-800 text-white text-xs font-bold rounded-lg transition">
                                        Beli
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition">
                                    Beli
                                </a>
                            @endauth
                        </div>
                    </div>

                </div>
            @empty
                <!-- Tampilan Jika Belum Ada Produk Di Database -->
                <div class="col-span-full py-12 text-center bg-white border border-slate-200 rounded-xl">
                    <p class="text-xs font-semibold text-slate-500">Tidak ada produk yang tersedia.</p>
                </div>
            @endforelse
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-4 text-center text-xs text-slate-400 font-medium">
        &copy; {{ date('Y') }} Via Store. All rights reserved.
    </footer>

</body>
</html>