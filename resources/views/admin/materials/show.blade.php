<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Detail Materi: {{ $material->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            {{-- Bagian Detail Materi --}}
            <div class="overflow-hidden mb-6 bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="mb-4 text-2xl font-bold">{{ $material->title }}</h3>
                    @if ($material->illustration_path)
                        <img src="{{ asset('storage/' . $material->illustration_path) }}" alt="Ilustrasi" class="mx-auto mb-6 w-full max-w-lg h-auto rounded-lg shadow-md">
                    @endif
                    <div class="max-w-none prose">
                        {!! nl2br(e($material->content)) !!}
                    </div>
                    <div class="pt-4 mt-6 text-sm text-gray-600 border-t">
                        <p><strong>Bab:</strong> {{ $material->chapter->title ?? 'N/A' }}</p>
                        <p><strong>Genre:</strong> {{ $material->genre->name ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            {{-- Bagian Aktivitas Terkait --}}
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- # PERBAIKAN: Menambahkan kembali header dan tombol "Tambah Aktivitas" --}}
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold">Aktivitas Terkait</h3>
                        <a href="{{ route('admin.activities.create', $material->id) }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-blue-600 rounded-md border border-transparent ring-blue-300 transition duration-150 ease-in-out hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring disabled:opacity-25">
                            Tambah Aktivitas Baru
                        </a>
                    </div>
                    {{-- Akhir Perbaikan --}}

                    @if (session('success'))
                        <div class="p-3 mb-4 text-sm font-medium text-green-600 bg-green-100 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="text-white bg-gray-800">
                                <tr>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left uppercase">Pertanyaan</th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left uppercase">Tipe</th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-right uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($material->activities->sortBy('position') as $activity)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ Str::limit($activity->question, 70) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($activity->type == 'essay') bg-purple-100 text-purple-800 
                                                @elseif($activity->type == 'multiple_choice') bg-green-100 text-green-800 
                                                @else bg-yellow-100 text-yellow-800 @endif">
                                                {{ str_replace('_', ' ', $activity->type) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                            <a href="{{ route('admin.activities.edit', $activity->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form action="{{ route('admin.activities.destroy', $activity->id) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Anda yakin ingin menghapus aktivitas ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                            Belum ada aktivitas untuk materi ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
