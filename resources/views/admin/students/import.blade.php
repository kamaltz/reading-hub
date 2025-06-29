<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Import Siswa dari Spreadsheet') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="p-4 mb-6 text-sm text-blue-800 bg-blue-100 rounded-lg border border-blue-200" role="alert">
                        <h3 class="font-bold">Petunjuk Import</h3>
                        <ol class="mt-2 list-decimal list-inside">
                            <li>Unduh template spreadsheet yang telah disediakan.</li>
                            <li>Isi data siswa sesuai dengan kolom yang ada (Nama, Email).</li>
                            <li>Password akan digenerate secara otomatis dan sama dengan alamat email. Siswa disarankan untuk mengubahnya setelah login pertama kali.</li>
                            <li>Simpan file dalam format .xlsx atau .csv.</li>
                            <li>Unggah file yang sudah diisi pada form di bawah ini.</li>
                        </ol>
                    </div>

                    <form method="POST" action="{{ route('admin.students.import') }}" enctype="multipart/form-data">
                        @csrf

                        <div>
                            <label for="file" class="block text-sm font-medium text-gray-700">File Spreadsheet (.xlsx, .csv)</label>
                            <input id="file" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" type="file" name="file" required />
                            @error('file') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-between items-center mt-6">
                            <a href="{{ route('admin.students.index') }}" class="text-sm text-gray-600 hover:underline">
                                Batal
                            </a>
                            
                            <div>
                                <a href="{{ route('admin.students.template') }}" class="mr-4 text-sm text-green-600 hover:underline">
                                    Unduh Template
                                </a>
                                <button type="submit" class="px-4 py-2 text-sm font-semibold tracking-widest text-white uppercase bg-gray-800 rounded-md border border-transparent hover:bg-gray-700">
                                    Import Siswa
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>