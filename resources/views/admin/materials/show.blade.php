<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Detail Materi: <span class="italic">{{ $material->title }}</span>
            </h2>
            <a href="{{ route('admin.materials.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50">
                &larr; Kembali ke Daftar Materi
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            {{-- Card untuk Detail Materi --}}
            <div class="overflow-hidden mb-8 bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold">{{ $material->title }}</h3>
                    <p class="text-sm text-gray-500">
                        Bab: {{ $material->chapter->title ?? 'N/A' }} | Genre: {{ $material->genre->name ?? 'N/A' }}
                    </p>
                    <div class="mt-4 max-w-none prose">
                        {!! $material->content !!}
                    </div>
                    <div class="mt-6 text-right">
                        <a href="{{ route('admin.materials.edit', $material) }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-gray-800 rounded-md border border-transparent hover:bg-gray-700">
                            Edit Materi
                        </a>
                    </div>
                </div>
            </div>

            {{-- Bagian untuk Aktivitas HOTS --}}
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Aktivitas HOTS Terkait</h3>
                        {{-- INI TOMBOL YANG ANDA CARI --}}
                        <a href="{{ route('admin.activities.create', ['material' => $material->id]) }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-700">
                            + Tambah Aktivitas Baru
                        </a>
                    </div>

                    @if($material->activities->isEmpty())
                        <p class="text-center text-gray-500">Belum ada aktivitas untuk materi ini.</p>
                    @else
                        <ul class="space-y-4">
                            @foreach($material->activities as $activity)
                                <li class="p-4 rounded-md border">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-semibold">{{ $activity->question }}</p>
                                            <span class="px-2 py-0.5 text-xs text-gray-700 bg-gray-200 rounded-full">{{ Str::title(str_replace('_', ' ', $activity->type)) }}</span>
                                        </div>
                                        <div class="flex ml-4 space-x-2 shrink-0">
                                            <a href="{{ route('admin.activities.edit', $activity) }}" class="text-sm text-blue-600 hover:text-blue-800">Edit</a>
                                            {{-- Melengkapi form hapus yang terpotong --}}
                                            <form action="{{ route('admin.activities.destroy', $activity) }}" method="POST" class="inline-block" onsubmit="return confirm('Anda yakin ingin menghapus aktivitas ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm text-red-600 hover:text-red-800">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>