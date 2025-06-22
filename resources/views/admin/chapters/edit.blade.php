<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Bab: {{ $chapter->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.chapters.update', $chapter) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="title" class="block font-medium text-sm text-gray-700">Judul Bab</label>
                            <input type="text" name="title" id="title" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="{{ old('title', $chapter->title) }}" required autofocus>
                            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="sequence" class="block font-medium text-sm text-gray-700">Nomor Urut</label>
                            <input type="number" name="sequence" id="sequence" class="block mt-1 w-full rounded-md shadow-sm border-