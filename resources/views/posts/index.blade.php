<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Daftar Post</h2>
            @can('create', App\Models\Post::class)
                <a href="{{ route('posts.create') }}" class="bg-indigo-600 text-white rounded px-4 py-2 text-sm">+ Post baru</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('status'))
                <div class="bg-green-100 text-green-800 rounded p-3">{{ session('status') }}</div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Judul</th>
                            <th>Penulis</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($posts as $post)
                            <tr class="border-b">
                                <td class="py-2">{{ $post->title }}</td>
                                <td>{{ $post->user->name }}</td>
                                <td>{{ $post->created_at->format('d M Y') }}</td>
                                <td class="space-x-2">
                                    @can('update', $post)
                                        <a class="text-indigo-600 underline" href="{{ route('posts.edit', $post) }}">Edit</a>
                                    @endcan
                                    @can('delete', $post)
                                        <form method="POST" action="{{ route('posts.destroy', $post) }}" class="inline"
                                              onsubmit="return confirm('Hapus post ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 underline">Hapus</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="py-4">Belum ada post.</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">{{ $posts->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
