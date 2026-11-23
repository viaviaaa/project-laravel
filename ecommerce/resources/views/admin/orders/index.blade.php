<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-navy-900 leading-tight flex items-center gap-2.5">
                    <i class="fa-solid fa-receipt text-navy-700"></i> Kelola Pesanan Pembeli (Admin)
                </h2>
                <p class="text-xs text-slate-500 mt-1 font-semibold">Kelola transaksi pembeli, verifikasi alamat, dan perbarui status pengiriman.</p>
            </div>
            <a href="{{ route('products.index') }}" class="bg-navy-900 hover:bg-navy-800 text-white font-extrabold text-xs px-5 py-3 rounded-2xl shadow-lg transition">
                <i class="fa-solid fa-boxes-stacked text-amber-400 mr-1"></i> Kelola Gudang Produk
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl flex items-center justify-between text-xs font-bold">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-emerald-500">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            <!-- 1. KARTU STATISTIK (POSISI PALING ATAS) -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-[11px] font-black text-slate-400 uppercase tracking-wider">TOTAL TRANSAKSI</p>
                        <h3 class="text-2xl font-black text-navy-900 mt-1">{{ $totalTransaksi ?? 0 }} Pesanan</h3>
                    </div>
                    <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center text-navy-900">
                        <i class="fa-solid fa-cart-shopping text-xl"></i>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-[11px] font-black text-slate-400 uppercase tracking-wider">TOTAL PENDAPATAN</p>
                        <h3 class="text-2xl font-black text-emerald-600 mt-1">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600">
                        <i class="fa-solid fa-wallet text-xl"></i>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-[11px] font-black text-slate-400 uppercase tracking-wider">PERLU DIPROSES</p>
                        <h3 class="text-2xl font-black text-amber-500 mt-1">{{ $perluDiproses ?? 0 }} Pesanan</h3>
                    </div>
                    <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-500">
                        <i class="fa-solid fa-clock text-xl"></i>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-[11px] font-black text-slate-400 uppercase tracking-wider">PESANAN SELESAI</p>
                        <h3 class="text-2xl font-black text-blue-600 mt-1">{{ $pesananSelesai ?? 0 }} Pesanan</h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600">
                        <i class="fa-solid fa-circle-check text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- 2. TABEL TRANSAKSI (POSISI DI BAWAH KARTU) -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <h3 class="font-extrabold text-navy-900 text-base">Semua Transaksi Masuk</h3>
                    <span class="text-xs font-bold text-slate-400">{{ $orders->count() }} Data Ditemukan</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-[11px] uppercase tracking-wider font-extrabold">
                                <th class="py-4 px-6">NO. RESI / ORDER</th>
                                <th class="py-4 px-6">PEMBELI</th>
                                <th class="py-4 px-6">BARANG YANG DIBELI</th>
                                <th class="py-4 px-6">ALAMAT & METODE</th>
                                <th class="py-4 px-6">TOTAL HARGA</th>
                                <th class="py-4 px-6">STATUS SAAT INI</th>
                                <th class="py-4 px-6 text-center">UBAH STATUS</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse ($orders as $order)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-4 px-6 font-black text-navy-900">
                                        {{ $order->order_number ?? '#ORD-00'.$order->id }}
                                        <span class="block text-[10px] text-slate-400 font-normal">
                                            {{ $order->created_at ? $order->created_at->format('d M Y, H:i') : '' }} WIB
                                        </span>
                                    </td>

                                    <td class="py-4 px-6 font-extrabold text-slate-800">
                                        {{ $order->user->name ?? 'Pembeli' }}
                                        <span class="block text-[11px] font-medium text-slate-400">
                                            {{ $order->user->email ?? '-' }}
                                        </span>
                                    </td>

                                    <td class="py-4 px-6 text-xs text-slate-400 italic font-medium">
                                        Detail produk langsung (1 Paket)
                                    </td>

                                    <td class="py-4 px-6 text-xs text-slate-600 font-semibold max-w-xs">
                                        <div class="flex items-center gap-1 text-rose-500 font-bold mb-1">
                                            <i class="fa-solid fa-location-dot"></i> {{ $order->shipping_address ?? '-' }}
                                        </div>
                                        <span class="inline-block bg-slate-100 text-slate-700 text-[10px] px-2 py-0.5 rounded font-bold">
                                            <i class="fa-solid fa-credit-card mr-1"></i> {{ $order->payment_method ?? 'Transfer Bank' }}
                                        </span>
                                    </td>

                                    <td class="py-4 px-6 font-black text-navy-900">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </td>

                                    <td class="py-4 px-6">
                                        @php
                                            $statusClasses = [
                                                'Pending'    => 'bg-amber-50 text-amber-700 border-amber-200',
                                                'Diproses'   => 'bg-blue-50 text-blue-700 border-blue-200',
                                                'Dikirim'    => 'bg-purple-50 text-purple-700 border-purple-200',
                                                'Selesai'    => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                'Dibatalkan' => 'bg-rose-50 text-rose-700 border-rose-200',
                                            ];
                                        @endphp
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border {{ $statusClasses[$order->status] ?? 'bg-slate-100 text-slate-700 border-slate-200' }}">
                                            {{ strtoupper($order->status) }}
                                        </span>
                                    </td>

                                    <td class="py-4 px-6">
                                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="flex items-center justify-center">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" onchange="this.form.submit()" class="bg-slate-50 border border-slate-300 rounded-xl px-3 py-1.5 text-xs font-bold text-navy-900 cursor-pointer">
                                                @foreach(['Pending', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'] as $stOption)
                                                    <option value="{{ $stOption }}" {{ $order->status === $stOption ? 'selected' : '' }}>
                                                        {{ $stOption }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center text-slate-400 font-bold">
                                        Belum ada pesanan dari pembeli.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>