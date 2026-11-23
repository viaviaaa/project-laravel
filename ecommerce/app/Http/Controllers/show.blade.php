public function show($id)
   
<x-app-layout>
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h1 class="text-2xl font-bold mb-4">{{ $product->name }}</h1>
            <p class="text-gray-700"><strong>Harga:</strong> Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}</p>
            <p class="text-gray-700"><strong>Stok:</strong> {{ $product->stock ?? 0 }}</p>
            
            <a href="{{ route('products.index') }}" class="mt-6 inline-block bg-gray-500 text-white px-4 py-2 rounded">
                ← Kembali ke Gudang
            </a>
        </div>
    </div>
</x-app-layout> 
}