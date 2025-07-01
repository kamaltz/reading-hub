<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Generator Siswa Massal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p class="mb-4 text-gray-600">
                        Fitur ini akan membuat sejumlah siswa baru dengan ID (NIS) dan email yang dibuat secara otomatis. ID siswa terakhir yang ada di sistem adalah <strong>{{ $lastStudentId ?: 'Belum ada siswa' }}</strong>. ID baru akan melanjutkan dari nomor tersebut.
                    </p>
                    <form method="POST" action="{{ route('admin.students.generate.store') }}">
                        @csrf
                        
                        <div>
                            <x-input-label for="count" :value="__('Jumlah Siswa yang Akan Dibuat')" />
                            <x-text-input id="count" class="block mt-1 w-full" type="number" name="count" :value="old('count', 10)" required min="1" max="500" />
                            <x-input-error :messages="$errors->get('count')" class="mt-2" />
                        </div>

                        <div class="flex justify-end items-center mt-4">
                            <a href="{{ route('admin.students.index') }}" class="mr-4 text-sm text-gray-600 hover:text-gray-900">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Buat Siswa') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>