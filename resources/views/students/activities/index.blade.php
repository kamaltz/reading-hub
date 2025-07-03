<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Daftar Aktivitas Pembelajaran
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="space-y-6">
                @forelse ($chapters as $chapter)
                    <div class="overflow-hidden bg-white rounded-lg shadow-sm">
                        <div class="p-6">
                            <h3 class="mb-4 text-xl font-bold text-gray-900">Bab: {{ $chapter->name }}</h3>
                            <div class="space-y-4">
                                @foreach ($chapter->readingMaterials as $material)
                                    @if ($material->activities->isNotEmpty())
                                        <h4 class="pt-2 text-lg font-semibold text-gray-800 border-t">{{ $material->title }}</h4>
                                        <ul class="space-y-3 list-disc list-inside">
                                            @foreach ($material->activities as $activity)
                                                <li class="p-4 bg-gray-50 rounded-md">
                                                    <p class="font-medium text-gray-700">{{ $activity->question }}</p>
                                                    @if($activity->image)
                                                        <img src="{{ asset('storage/' . $activity->image) }}" alt="Question Image" class="max-w-md h-auto mt-2 rounded-lg shadow-md">
                                                    @endif
                                                    {{-- Di sini Anda bisa menambahkan link untuk mengerjakan soal --}}
                                                    <a href="#" class="mt-2 text-sm text-indigo-600 hover:text-indigo-800">
                                                        Kerjakan Soal &rarr;
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-500 bg-white rounded-lg shadow-sm">
                        <p>Belum ada aktivitas yang tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
