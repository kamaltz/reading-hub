<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Manajemen Materi Bacaan
            </h2>
            <a href="{{ route('admin.materials.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-700">
                + Tambah Materi Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="mb-4 text-sm font-medium text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="text-white bg-gray-800">
                                <tr>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left uppercase">Judul Materi</th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left uppercase">Bab</th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left uppercase">Genre</th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-center uppercase">Jumlah Aktivitas</th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-right uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($materials as $material)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 font-medium whitespace-nowrap">{{ $material->title }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $material->chapter->title ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $material->genre->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-center whitespace-nowrap">{{ $material->activities_count }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                            {{-- INI TOMBOL KUNCI UNTUK MEMPERBAIKI ALUR KERJA --}}
                                            <a href="{{ route('admin.materials.show', $material) }}" class="px-3 py-1 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                                                Kelola Aktivitas
                                            </a>
                                            <a href="{{ route('admin.materials.edit', $material) }}" class="ml-2 text-indigo-600 hover:text-indigo-900">Edit</a>
                                            {{-- Form Hapus bisa ditambahkan di sini jika perlu --}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-4 text-center text-gray-500">
                                            Belum ada materi bacaan yang ditambahkan.
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