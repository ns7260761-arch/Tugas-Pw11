<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog Produk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="max-w-6xl mx-auto p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Katalog Produk</h1>
            <div class="space-x-3 text-sm">
                @auth
                    <a class="text-indigo-600 underline" href="{{ route('dashboard') }}">Dashboard</a>
                @else
                    <a class="text-indigo-600 underline" href="{{ route('login') }}">Login</a>
                    <a class="text-indigo-600 underline" href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </div>

        <form method="GET" class="flex flex-wrap gap-2 mb-4">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari produk..."
                   class="border rounded px-3 py-2 w-64">
            <select name="category" class="border rounded px-3 py-2">
                <option value="">Semua kategori</option>
                @foreach ($categories as $c)
                    <option value="{{ $c->slug }}" @selected(request('category') === $c->slug)>
                        {{ $c->name }} ({{ $c->products_count }})
                    </option>
                @endforeach
            </select>
            <button class="bg-indigo-600 text-white rounded px-4 py-2">Filter</button>
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse ($products as $p)
                <div class="bg-white rounded-lg shadow p-4">
                    <p class="text-xs text-gray-500">{{ $p->category->name }}</p>
                    <h2 class="font-semibold">{{ $p->name }}</h2>
                    <p class="text-indigo-700 font-bold mt-1">Rp {{ number_format($p->price, 0, ',', '.') }}</p>
                    <p class="text-sm text-gray-600 mt-2">{{ $p->description }}</p>
                    <p class="text-xs mt-2 {{ $p->stock > 0 ? 'text-green-700' : 'text-red-700' }}">
                        {{ $p->stock > 0 ? 'Stok: ' . $p->stock : 'Stok habis' }}
                    </p>
                </div>
            @empty
                <p>Tidak ada produk.</p>
            @endforelse
        </div>

        <div class="mt-6">{{ $products->links() }}</div>
    </div>
</body>
</html>
