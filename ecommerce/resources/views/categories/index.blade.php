<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Kategori Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Form Tambah Kategori -->
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h3 class="text-lg font-bold mb-4 text-gray-700">Tambah Kategori Baru</h3>
                
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('categories.store') }}" method="POST" class="flex gap-4 items-center">
                    @csrf
                    <input type="text" name="name" placeholder="Nama Kategori (contoh: Pakaian)" required 
                           style="padding: 10px; border: 1px solid #ccc; border-radius: 6px; width: 300px;">
                    
                    <button type="submit" 
                            style="background-color: #2563eb; color: #ffffff; padding: 10px 20px; border-radius: 6px; font-weight: bold; border: none; cursor: pointer;">
                        + Simpan Kategori
                    </button>
                </form>
            </div>

            <!-- Tabel Daftar Kategori -->
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h3 class="text-lg font-bold mb-4 text-gray-700">Daftar Kategori</h3>
                <table class="w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-3 border">No</th>
                            <th class="p-3 border">Nama Kategori</th>
                            <th class="p-3 border">Slug</th>
                            <th class="p-3 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $index => $category)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3 border">{{ $index + 1 }}</td>
                                <td class="p-3 border font-semibold">{{ $category->name }}</td>
                                <td class="p-3 border text-gray-500">{{ $category->slug }}</td>
                                <td class="p-3 border">
                                    <div class="flex gap-2">
                                        <a href="{{ route('categories.edit', $category->id) }}" 
                                           style="background-color: #eab308; color: white; padding: 5px 12px; border-radius: 4px; text-decoration: none; font-size: 14px; font-weight: bold;">
                                            Edit
                                        </a>
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    style="background-color: #dc2626; color: white; padding: 5px 12px; border-radius: 4px; font-size: 14px; font-weight: bold; border: none; cursor: pointer;">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center p-4 text-gray-500">Belum ada kategori.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>