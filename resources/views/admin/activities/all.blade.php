<x-app-layout>
    <div class="px-6 py-8">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold text-white">Semua Aktivitas HOTS</h2>
        </div>

        <div class="mt-8">
            <div class="overflow-hidden rounded-xl border bg-gray-800/50 border-gray-700/50">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-800">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-300 uppercase">Pertanyaan</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-300 uppercase">Tipe</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-300 uppercase">Materi Induk</th>
                            <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @forelse ($activities as $activity)
                            <tr>
                                <td class="px-6 py-4 text-sm text-white whitespace-nowrap">{{ Str::limit($activity->question, 60) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-400 whitespace-nowrap">{{ $activity->type == 'multiple_choice' ? 'Pilihan Ganda' : 'Essay' }}</td>
                                <td class="px-6 py-4 text-sm text-indigo-400 whitespace-nowrap hover:text-indigo-300">
                                    <a href="{{ route('admin.materials.edit', $activity->readingMaterial) }}">
                                        {{ Str::limit($activity->readingMaterial->title, 40) }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <a href="{{ route('admin.activities.edit', $activity) }}" class="text-indigo-400 hover:text-indigo-300">Edit</a>
                                    <form action="{{ route('admin.activities.destroy', $activity) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Apakah Anda yakin ingin menghapus aktivitas ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-400">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-6 py-4 text-center text-gray-400">Belum ada aktivitas yang dibuat.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4 text-white">
                {{ $activities->links() }}
            </div>
        </div>
    </div>
</x-app-layout>