@csrf

<div class="mb-4">
    <label for="title" class="block font-medium mb-1">Judul</label>
    <input id="title" name="title" type="text" value="{{ old('title', $post->title ?? '') }}"
           class="border rounded w-full px-3 py-2 text-gray-900" required>
    @error('title') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div class="mb-4">
    <label for="body" class="block font-medium mb-1">Isi</label>
    <textarea id="body" name="body" rows="8"
              class="border rounded w-full px-3 py-2 text-gray-900" required>{{ old('body', $post->body ?? '') }}</textarea>
    @error('body') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<button class="bg-indigo-600 text-white rounded px-4 py-2">Simpan</button>
<a href="{{ route('posts.index') }}" class="ml-3 underline">Batal</a>
