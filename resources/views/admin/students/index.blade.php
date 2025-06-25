<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Pengelolaan Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="mb-4 text-lg font-semibold">Daftar Progres Siswa</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase border-b">Nama Siswa</th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase border-b">Email</th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase border-b">Aktivitas Dicoba</th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase border-b">Jawaban Benar</th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase border-b">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($students as $student)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $student->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $student->email }}</td>
                                        <td class="px-6 py-4 text-center whitespace-nowrap">{{ $student->attempted_answers_count }}</td>
                                        <td class="px-6 py-4 text-center whitespace-nowrap">{{ $student->correct_answers_count }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('admin.students.show', $student->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                                Lihat Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center">Tidak ada data siswa.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $students->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
