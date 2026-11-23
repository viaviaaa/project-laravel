<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-2xl text-navy-900 leading-tight flex items-center gap-2.5">
                <i class="fa-solid fa-receipt text-navy-700"></i> Pesanan Saya
            </h2>
            <a href="{{ url('/') }}" class="bg-navy-900 hover:bg-navy-800 text-white font-extrabold text-xs px-5 py-3 rounded-2xl shadow-md transition flex items-center gap-2">
                <i class="fa-solid fa-store text-amber-400"></i> Kembali ke Toko
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- TABEL PESANAN PEMBELI -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="font-extrabold text-navy-900 text-base">Riwayat Belanja Saya</h3>
                    <span class="text-xs font-bold text-slate-400">{{ count($orders ?? []) }} Pesanan</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-[11px] uppercase tracking-wider font-extrabold">
                                <th class="py-4 px-6">NO. PESANAN</th>
                                <th class="py-4 px-6">TANGGAL</th>
                                <th class="py-4 px-6">ALAMAT PENGIRIMAN</th>
                                <th class="py-4 px-6">METODE PEMBAYARAN</th>
                                <th class="py-4 px-6">TOTAL HARGA</th>
                                <th class="py-4 px-6">STATUS PESANAN</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse ($orders ?? [] as $order)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-4 px-6 font-black text-navy-900">
                                        {{ $order->order_number ?? ('#ORD-00' . ($order->id ?? '')) }}
                                    </td>
                                    <td class="py-4 px-6 text-xs text-slate-500 font-semibold">
                                        {{ !empty($order->created_at) ? \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') : '-' }} WIB
                                    </td>
                                    <td class="py-4 px-6 text-xs text-slate-700 font-semibold max-w-xs truncate">
                                        {{ $order->shipping_address ?? '-' }}
                                    </td>
                                    <td class="py-4 px-6 text-xs font-bold text-navy-900">
                                        {{ $order->payment_method ?? 'Transfer Bank' }}
                                    </td>
                                    <td class="py-4 px-6 font-black text-navy-900">
                                        Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-6">
                                        @php
                                            $st = $order->status ?? 'Pending';
                                            $statusClasses = [
                                                'Pending'    => 'bg-amber-50 text-amber-700 border-amber-200',
                                                'Diproses'   => 'bg-blue-50 text-blue-700 border-blue-200',
                                                'Dikirim'    => 'bg-purple-50 text-purple-700 border-purple-200',
                                                'Selesai'    => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                'Dibatalkan' => 'bg-rose-50 text-rose-700 border-rose-200',
                                            ];
                                        @endphp
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border {{ $statusClasses[$st] ?? 'bg-slate-100 text-slate-700 border-slate-200' }}">
                                            {{ strtoupper($st) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center text-slate-400 font-bold">
                                        Belum ada riwayat pesanan.
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