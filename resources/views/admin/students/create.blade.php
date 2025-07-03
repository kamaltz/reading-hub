<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Tambah Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.students.store') }}">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Nama')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="email_prefix" :value="__('Username Email')" />
                            <div class="flex items-center">
                                <x-text-input id="email_prefix" class="block mt-1 flex-1" type="text" name="email_prefix" :value="old('email_prefix')" required />
                                <span class="ml-2 text-sm text-gray-600">@readhub.my.id</span>
                            </div>
                            <x-input-error :messages="$errors->get('email_prefix')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Contoh: jika diisi "john", email akan menjadi john@readhub.my.id</p>
                        </div>

                        <div class="flex justify-end items-center mt-4">
                             <a href="{{ route('admin.students.index') }}" class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Batal
                            </a>
                            <x-primary-button class="ms-4">
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>