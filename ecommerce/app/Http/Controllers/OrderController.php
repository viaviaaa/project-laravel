<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Nampilin daftar pesanan buat pembeli
    public function index()
    {
        // Auto-Redirect jika Admin
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.orders.index');
        }

        $orders = Order::where('user_id', Auth::id())->latest()->get();

        // Statistik khusus PEMBELI (TANPA Total Pendapatan)
        $totalTransaksi = $orders->count();
        $perluDiproses  = $orders->whereIn('status', ['Pending', 'Diproses'])->count();
        $pesananSelesai = $orders->where('status', 'Selesai')->count();
        
        return view('orders.index', compact('orders', 'totalTransaksi', 'perluDiproses', 'pesananSelesai'));
    }

    // Menyimpan pesanan baru dari checkout
    public function store(Request $request)
    {
        $request->validate([
            'total_price'      => 'required|numeric',
            'payment_method'   => 'required|string',
            'shipping_address' => 'required|string|max:500',
        ]);

        $orderNumber = 'ORD-' . time() . rand(100, 999);

        Order::create([
            'order_number'     => $orderNumber,
            'user_id'          => Auth::id(),
            'total_price'      => $request->total_price,
            'payment_method'   => $request->payment_method,
            'shipping_address' => $request->shipping_address,
            'status'           => 'Pending',
        ]);

        return redirect()->back()->with('success', 'Pesanan ' . $orderNumber . ' berhasil dibuat!');
    }

    // [KHUSUS ADMIN] Menampilkan seluruh pesanan & statistik lengkap
    public function adminIndex(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak!');
        }

        $status = $request->query('status');

        // Data statistik seluruh pesanan di database
        $allOrders = Order::all();
        $totalTransaksi  = $allOrders->count();
        // Pendapatan dihitung dari transaksi yang statusnya 'Selesai' (atau yang tidak dikanal/dibatalkan)
        $totalPendapatan = $allOrders->where('status', 'Selesai')->sum('total_price');
        $perluDiproses   = $allOrders->whereIn('status', ['Pending', 'Diproses'])->count();
        $pesananSelesai  = $allOrders->where('status', 'Selesai')->count();

        // Data transaksi untuk tabel (bisa difilter status)
        $orders = Order::when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->with('user')
            ->latest()
            ->get();

        return view('admin.orders.index', compact(
            'orders', 'status', 'totalTransaksi', 'totalPendapatan', 'perluDiproses', 'pesananSelesai'
        ));
    }

    // [KHUSUS ADMIN] Update status transaksi
    public function updateStatus(Request $request, Order $order)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak!');
        }

        $request->validate([
            'status' => 'required|string|in:Pending,Diproses,Dikirim,Selesai,Dibatalkan',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pesanan ' . $order->order_number . ' berhasil diperbarui!');
    }
}