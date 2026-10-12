<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Kelola User &amp; Role</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('status'))
                <div class="bg-green-100 text-green-800 rounded p-3">{{ session('status') }}</div>
            @endif
            @error('role')
                <div class="bg-red-100 text-red-800 rounded p-3">{{ $message }}</div>
            @enderror

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b"><th class="py-2">Nama</th><th>Email</th><th>Role</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $u)
                            <tr class="border-b">
                                <td class="py-2">{{ $u->name }}</td>
                                <td>{{ $u->email }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.users.role', $u) }}" class="flex gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" class="border rounded px-2 py-1 text-gray-900">
                                            @foreach (['admin', 'editor', 'user'] as $r)
                                                <option value="{{ $r }}" @selected($u->role === $r)>{{ $r }}</option>
                                            @endforeach
                                        </select>
                                        <button class="bg-indigo-600 text-white rounded px-3 py-1 text-sm">Simpan</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">{{ $users->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
