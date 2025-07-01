<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Generator Akun Siswa dengan Rentang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="mb-4 text-gray-600 dark:text-gray-400">
                        Fitur ini akan membuat akun siswa berdasarkan ID awal dan rentang nomor urut. Email akan dibuat otomatis menggunakan format <strong>(ID Siswa)@readhub.my.id</strong>.
                    </p>
                    <form method="POST" action="{{ route('admin.students.generate.store') }}">
                        @csrf
                        
                        {{-- ID Awal (Prefix) --}}
                        <div class="mb-4">
                            <label for="id_prefix" class="block text-sm font-medium text-gray-700 dark:text-gray-300">ID Awal (Contoh: 2206000)</label>
                            <x-text-input id="id_prefix" class="block mt-1 w-full" type="text" name="id_prefix" :value="old('id_prefix', '24' . date('m'))" required />
                            <x-input-error :messages="$errors->get('id_prefix')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Ini adalah bagian depan dari ID Siswa/NIS.</p>
                        </div>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            {{-- Rentang Awal --}}
                            <div class="mb-4">
                                <label for="range_start" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Urut Awal</label>
                                <x-text-input id="range_start" class="block mt-1 w-full" type="number" name="range_start" :value="old('range_start', 1)" required min="1" />
                                <x-input-error :messages="$errors->get('range_start')" class="mt-2" />
                            </div>

                            {{-- Rentang Akhir --}}
                            <div class="mb-4">
                                <label for="range_end" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Urut Akhir</label>
                                <x-text-input id="range_end" class="block mt-1 w-full" type="number" name="range_end" :value="old('range_end', 100)" required min="1" />
                                <x-input-error :messages="$errors->get('range_end')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex justify-end items-center mt-4">
                            <a href="{{ route('admin.students.index') }}" class="mr-4 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Buat Akun Siswa') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
