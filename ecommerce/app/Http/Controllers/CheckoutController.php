<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        $cart = session()->get('cart');

        if (!$cart || count($cart) == 0) {
            return redirect()->back()->with('error', 'Keranjang lu kosong bos!');
        }

        $totalPrice = 0;
        foreach ($cart as $id => $details) {
            $totalPrice += $details['price'] * $details['quantity'];
        }

        // Bikin pesanan, masukin order_number dan alamat sementara
        $order = Order::create([
            'order_number' => 'INV-' . time(), 
            'user_id' => Auth::id(), 
            'total_price' => $totalPrice,
            'status' => 'pending',
            'shipping_address' => 'Alamat belum diatur', // Akal-akalan sementara biar lolos
        ]);

        foreach ($cart as $id => $details) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $details['quantity'],
                'price' => $details['price'],
            ]);

            $product = Product::find($id);
            if($product) {
                $product->stock -= $details['quantity'];
                $product->save(); 
            }
        }

        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'Checkout Sukses! Barang lu lagi diproses.');
    }
}