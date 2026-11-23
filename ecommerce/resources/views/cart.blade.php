<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Keranjang Belanja</h2>
            <a href="{{ url('/') }}" class="text-blue-500 hover:underline">← Lanjut Belanja</a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(count($cart) > 0)
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">Nama Produk</th>
                        <th class="py-2">Harga</th>
                        <th class="py-2">Jumlah</th>
                        <th class="py-2">Subtotal</th>
                        <th class="py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($cart as $id => $details)
                        @php $total += $details['price'] * $details['quantity']; @endphp
                        <tr class="border-b">
                            <td class="py-4">{{ $details['name'] }}</td>
                            <td class="py-4">Rp {{ number_format($details['price'], 0, ',', '.') }}</td>
                            <td class="py-4">{{ $details['quantity'] }}</td>
                            <td class="py-4">Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</td>
                            <td class="py-4 text-center">
                                <a href="{{ route('cart.remove', $id) }}" class="text-red-500 hover:text-red-700 font-bold">Hapus</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-6 flex justify-between items-center">
                <h3 class="text-xl font-bold">Total: Rp {{ number_format($total, 0, ',', '.') }}</h3>
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 font-bold">
                        Checkout Sekarang
                    </button>
                </form>
            </div>
        @else
            <p class="text-gray-500 text-center py-8">Keranjang lu masih kosong nih bos.</p>
        @endif
    </div>

</body>
</html>