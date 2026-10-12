<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                <p>Halo, <strong>{{ auth()->user()->name }}</strong>!
                    Role kamu:
                    <span class="px-2 py-1 text-sm rounded bg-indigo-100 text-indigo-800">{{ auth()->user()->role }}</span>
                </p>

                <ul class="mt-4 list-disc ml-6 space-y-1">
                    <li><a class="text-indigo-600 underline" href="{{ route('products.index') }}">Katalog produk (publik)</a></li>
                    <li><a class="text-indigo-600 underline" href="{{ route('posts.index') }}">Daftar post (semua role)</a></li>
                    @if (auth()->user()->isAdmin() || auth()->user()->isEditor())
                        <li><a class="text-indigo-600 underline" href="{{ route('posts.create') }}">Buat post baru (admin &amp; editor)</a></li>
                    @endif
                    @if (auth()->user()->isAdmin())
                        <li><a class="text-indigo-600 underline" href="{{ route('admin.users') }}">Kelola user &amp; role (admin saja)</a></li>
                        <li><a class="text-indigo-600 underline" href="{{ route('admin.demo.eager') }}">Demo eager loading (admin saja)</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
