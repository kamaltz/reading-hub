<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Detail Materi: {{ $material->title }}
            </h2>
            <a href="{{ route('admin.materials.index') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                &larr; Kembali ke Daftar Materi
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            
            {{-- Bagian Konten Materi --}}
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white">
                    @if ($material->illustration)
                        <img src="{{ asset('storage/' . $material->illustration) }}" alt="Ilustrasi" class="object-cover mb-6 w-full h-auto max-h-96 rounded-lg shadow-md">
                    @endif

                    <div class="max-w-none prose prose-gray bg-white p-6 rounded-lg border border-gray-200">
                        <style>
                            .prose * { color: #374151 !important; }
                            .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 { color: #111827 !important; font-weight: 600; }
                            .prose p { color: #374151 !important; line-height: 1.7; }
                            .prose strong { color: #111827 !important; font-weight: 600; }
                            .prose ul, .prose ol, .prose li { color: #374151 !important; }
                            .prose blockquote { color: #4b5563 !important; border-left: 4px solid #d1d5db; }
                        </style>
                        {!! $material->content !!}
                    </div>
                </div>
            </div>

            {{-- Bagian Manajemen Aktivitas --}}
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Daftar Aktivitas (Bisa diurutkan)</h3>
                        <a href="{{ route('admin.activities.create', ['material_id' => $material->id]) }}" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                            + Tambah Aktivitas
                        </a>
                    </div>

                    <div id="reorder-status" class="hidden p-4 mb-4 text-sm rounded-md"></div>

                    <div id="sortable-activities" class="mt-4 border-t border-gray-200">
                        @forelse ($material->activities->sortBy('position') as $activity)
                            <div data-id="{{ $activity->id }}" class="flex justify-between items-center p-4 border-b border-gray-200 group bg-white">
                                <div class="flex flex-grow items-center">
                                    {{-- Handle untuk Drag and Drop --}}
                                    <svg class="mr-4 w-5 h-5 text-gray-400 cursor-grab group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $activity->question }}</p>
                                        <p class="text-sm text-gray-600">Tipe: {{ ucwords(str_replace('_', ' ', $activity->type)) }}</p>
                                    </div>
                                </div>
                                <div class="flex flex-shrink-0 items-center space-x-4">
                                    {{-- Tombol Duplikat --}}
                                    <form action="{{ route('admin.activities.duplicate', $activity) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="text-blue-600 hover:text-blue-800 font-medium" title="Duplikat">
                                            Duplikat
                                        </button>
                                    </form>
                                    
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('admin.activities.edit', $activity) }}" class="text-yellow-600 hover:text-yellow-800 font-medium" title="Edit">
                                        Edit
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('admin.activities.destroy', $activity) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus aktivitas ini?');" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium" title="Hapus">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="py-8 text-center">
                                <p class="text-gray-600">Belum ada aktivitas untuk materi ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Script untuk SortableJS (Reorder) --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const el = document.getElementById('sortable-activities');
            if (el) {
                const sortable = Sortable.create(el, {
                    animation: 150,
                    ghostClass: 'bg-indigo-100',
                    onEnd: function (evt) {
                        const order = Array.from(sortable.el.children).map(item => item.dataset.id);
                        
                        const statusDiv = document.getElementById('reorder-status');

                        fetch('{{ route("admin.activities.reorder") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ order: order })
                        })
                        .then(response => response.json())
                        .then(data => {
                            statusDiv.textContent = data.message || 'Urutan berhasil diperbarui.';
                            statusDiv.className = 'mb-4 p-4 text-sm rounded-md bg-green-100 dark:bg-green-800/50 text-green-700 dark:text-green-300';
                            statusDiv.classList.remove('hidden');
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            statusDiv.textContent = 'Terjadi kesalahan saat menyimpan urutan.';
                            statusDiv.className = 'mb-4 p-4 text-sm rounded-md bg-red-100 dark:bg-red-800/50 text-red-700 dark:text-red-300';
                            statusDiv.classList.remove('hidden');
                        });
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
