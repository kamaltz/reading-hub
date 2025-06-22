<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Bab Baru
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.chapters.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="block font-medium text-sm text-gray-700">Judul Bab</label>
                            <input type="text" name="title" id="title" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required autofocus>
                            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="sequence" class="block font-medium text-sm text-gray-700">Nomor Urut</label>
                            <input type="number" name="sequence" id="sequence" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                            @error('sequence') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Simpan Bab
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>