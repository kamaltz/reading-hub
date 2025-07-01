<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Generate Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.students.generate') }}">
                        @csrf

                        <div>
                            <x-input-label for="id_prefix" :value="__('Prefix ID (contoh: 2206)')" />
                            <x-text-input id="id_prefix" class="block mt-1 w-full" type="text" name="id_prefix" :value="old('id_prefix')" required />
                            <x-input-error :messages="$errors->get('id_prefix')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="range_start" :value="__('Range Awal (3 digit terakhir, misal: 1)')" />
                            <x-text-input id="range_start" class="block mt-1 w-full" type="number" name="range_start" :value="old('range_start')" required />
                            <x-input-error :messages="$errors->get('range_start')" class="mt-2" />
                        </div>
                        
                        <div class="mt-4">
                            <x-input-label for="range_end" :value="__('Range Akhir (3 digit terakhir, misal: 169)')" />
                            <x-text-input id="range_end" class="block mt-1 w-full" type="number" name="range_end" :value="old('range_end')" required />
                            <x-input-error :messages="$errors->get('range_end')" class="mt-2" />
                        </div>

                        <div class="flex justify-end items-center mt-4">
                             <a href="{{ route('admin.students.index') }}" class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Batal
                            </a>
                            <x-primary-button class="ms-4">
                                {{ __('Generate') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>