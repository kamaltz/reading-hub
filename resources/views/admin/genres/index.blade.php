<x-app-layout>
    <div class="px-6 py-8">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold text-white">Manajemen Genre</h2>
            <a href="{{ route('admin.genres.create') }}" class="px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-500">
                Tambah Genre Baru
            </a>
        </div>

        <div class="mt-8">
            {{-- Menampilkan pesan sukses jika ada --}}
            @if (session('success'))
                <div class="p-4 mb-4 text-sm text-green-200 rounded-lg border bg-green-800/50 border-green-700/50">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-xl border bg-gray-800/50 border-gray-700/50">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-800">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-300 uppercase">Nama Genre</th>
                            <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @forelse ($genres as $genre)
                            <tr>
                                <td class="px-6 py-4 text-sm text-white whitespace-nowrap">{{ $genre->name }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <a href="{{ route('admin.genres.edit', $genre) }}" class="text-indigo-400 hover:text-indigo-300">Edit</a>
                                    <form action="{{ route('admin.genres.destroy', $genre) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Apakah Anda yakin ingin menghapus genre ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-400">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="px-6 py-4 text-center text-gray-400">Belum ada genre yang ditambahkan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>