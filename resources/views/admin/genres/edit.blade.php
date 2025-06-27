<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Edit Genre: {{ $genre->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.genres.update', $genre->id) }}">
                        @csrf
                        @method('PUT')

                        {{-- Input untuk Nama Genre --}}
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Genre</label>
                            <input type="text" name="name" id="name" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" value="{{ old('name', $genre->name) }}" required autofocus>
                            @error('name') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        {{-- Tombol untuk menyimpan perubahan --}}
                        <div class="flex justify-end items-center mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-gray-800 rounded-md border border-transparent hover:bg-gray-700">
                                Perbarui Genre
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
