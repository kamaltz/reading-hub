<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Edit Bab: {{ $chapter->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Form untuk mengupdate data bab --}}
                    <form method="POST" action="{{ route('admin.chapters.update', $chapter->id) }}">
                        @csrf
                        @method('PUT')

                        {{-- Input untuk Judul Bab --}}
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Judul Bab</label>
                            <input type="text" name="title" id="title" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" value="{{ old('title', $chapter->title) }}" required autofocus>
                            @error('title') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        {{-- Input untuk Nomor Urut (jika ada, misalnya untuk mengurutkan bab) --}}
                        <div class="mb-4">
                            <label for="sequence" class="block text-sm font-medium text-gray-700">Nomor Urut</label>
                            <input type="number" name="sequence" id="sequence" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" value="{{ old('sequence', $chapter->sequence ?? 0) }}" required>
                            @error('sequence') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        {{-- Tombol untuk menyimpan perubahan --}}
                        <div class="flex justify-end items-center mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-gray-800 rounded-md border border-transparent hover:bg-gray-700">
                                Perbarui Bab
                            </button>
                        </div>
                    </form>
                </div> {{-- Ini adalah penutup untuk div p-6 --}}
            </div> {{-- Ini adalah penutup untuk div bg-white --}}
        </div> {{-- Ini adalah penutup untuk div max-w-7xl --}}
    </div> {{-- Ini adalah penutup untuk div py-12 --}}
</x-app-layout> {{-- Ini adalah penutup untuk komponen layout --}}
