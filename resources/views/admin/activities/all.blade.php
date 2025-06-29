<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Semua Aktivitas
            </h2>
            {{-- PERBAIKAN: Tambahkan tombol ini untuk memandu admin ke alur yang benar --}}
            <a href="{{ route('admin.materials.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-700">
                Pilih Materi untuk Tambah Aktivitas
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- PERBAIKAN: Tambahkan kotak informasi untuk memperjelas alur kerja --}}
                    <div class="p-4 mb-6 text-sm text-blue-800 bg-blue-100 rounded-lg border border-blue-200" role="alert">
                        <span class="font-medium">Petunjuk:</span> Untuk menambah aktivitas baru, Anda harus memilih materi terlebih dahulu dari halaman
                        <a href="{{ route('admin.materials.index') }}" class="font-semibold underline hover:text-blue-900">Daftar Materi Bacaan</a>.
                    </div>

                    @if (session('success'))
                        <div class="mb-4 text-sm font-medium text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="text-white bg-gray-800">
                                <tr>
                                    {{-- PERUBAHAN 1: Tambah kolom untuk handle drag --}}
                                    <th class="px-4 py-3 w-10"></th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left uppercase">Pertanyaan</th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left uppercase">Tipe</th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left uppercase">Materi Terkait</th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-right uppercase">Aksi</th>
                                </tr>
                            </thead>
                            {{-- PERUBAHAN 2: Tambahkan id="activities-list" pada tbody --}}
                            <tbody id="activities-list">
                                {{-- PERUBAHAN 3: Urutkan berdasarkan 'position' --}}
                                @foreach ($activities->sortBy('position') as $activity)
                                    {{-- PERUBAHAN 4: Tambahkan data-id pada tr --}}
                                    <tr class="border-b" data-id="{{ $activity->id }}">
                                        {{-- PERUBAHAN 5: Tambah ikon untuk drag handle --}}
                                        <td class="px-4 py-4 text-gray-400 cursor-move">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-grip-vertical" viewBox="0 0 16 16">
                                                <path d="M7 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zM7 5a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zM7 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm-3 3a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm-3 3a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                            </svg>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ Str::limit($activity->question, 50) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $activity->type }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($activity->readingMaterial)
                                                <a href="{{ route('admin.materials.edit', $activity->readingMaterial) }}">{{ Str::limit($activity->readingMaterial->title, 40) }}</a>
                                            @else
                                                <span class="italic text-gray-400">No Material Linked</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                            <a href="{{ route('admin.activities.edit', $activity) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            
                                            {{-- Tombol Duplikasi --}}
                                            <form action="{{ route('admin.activities.duplicate', $activity) }}" method="POST" class="inline-block ml-2">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-900">Duplikat</button>
                                            </form>

                                            <form action="{{ route('admin.activities.destroy', $activity) }}" method="POST" class="inline-block ml-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Anda yakin?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- PERUBAHAN 6: Tambahkan blok script di bawah --}}
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        const activitiesList = document.getElementById('activities-list');
        if (activitiesList) {
            new Sortable(activitiesList, {
                animation: 150,
                handle: '.cursor-move', // Menentukan elemen mana yang bisa di-drag
                ghostClass: 'bg-blue-100',
                onEnd: function (evt) {
                    const itemIds = Array.from(evt.target.children).map(row => row.dataset.id);

                    fetch('{{ route("admin.activities.reorder") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ ids: itemIds })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Order updated successfully:', data);
                    })
                    .catch(error => {
                        console.error('Error updating order:', error);
                    });
                }
            });
        }
    </script>
    @endpush

</x-app-layout>