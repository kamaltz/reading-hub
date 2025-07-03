<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Tambah Aktivitas Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 bg-white">
                    <!-- AI Question Generator Section -->
                    <div class="overflow-hidden mb-10 bg-white rounded-2xl border border-gray-100 shadow-lg">
                        <div class="px-8 py-6 bg-gradient-to-r from-indigo-600 to-purple-600">
                            <h3 class="flex items-center text-2xl font-bold text-white">
                                <span class="mr-3">🤖</span>
                                AI Question Generator
                            </h3>
                            <p class="mt-2 text-indigo-100">Generate up to 5 questions automatically using AI</p>
                        </div>
                        
                        <div class="p-8">
                            <div class="grid grid-cols-1 gap-8 xl:grid-cols-2">
                                <!-- Generate from Prompt -->
                                <div class="space-y-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex justify-center items-center w-10 h-10 bg-purple-100 rounded-full">
                                            <span class="font-bold text-purple-600">1</span>
                                        </div>
                                        <h4 class="text-lg font-semibold text-gray-800">Generate from Prompt</h4>
                                    </div>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block mb-2 text-sm font-medium text-gray-700">Describe what questions you want:</label>
                                            <textarea style="color: grey;"id="aiPrompt" rows="4" placeholder="Example: Create questions about photosynthesis process for high school biology students" class="px-4 py-3 w-full text-sm rounded-lg border border-gray-300 resize-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"></textarea>
                                        </div>
                                        
                                        <div>
                                            <label class="block mb-3 text-sm font-medium text-gray-700">Question Types:</label>
                                            <div class="grid grid-cols-2 gap-3">
                                                <label class="flex items-center p-3 rounded-lg border border-gray-300 transition-colors cursor-pointer hover:bg-purple-50 hover:border-purple-300">
                                                    <input type="checkbox" class="w-4 h-4 text-purple-600 rounded question-type" value="multiple_choice" checked>
                                                    <span class="ml-3 text-sm font-semibold text-gray-800">🔤 Multiple Choice</span>
                                                </label>
                                                <label class="flex items-center p-3 rounded-lg border border-gray-300 transition-colors cursor-pointer hover:bg-purple-50 hover:border-purple-300">
                                                    <input type="checkbox" class="w-4 h-4 text-purple-600 rounded question-type" value="essay">
                                                    <span class="ml-3 text-sm font-semibold text-gray-800">📝 Essay</span>
                                                </label>
                                                <label class="flex items-center p-3 rounded-lg border border-gray-300 transition-colors cursor-pointer hover:bg-purple-50 hover:border-purple-300">
                                                    <input type="checkbox" class="w-4 h-4 text-purple-600 rounded question-type" value="true_false">
                                                    <span class="ml-3 text-sm font-semibold text-gray-800">✅ True/False</span>
                                                </label>
                                                <label class="flex items-center p-3 rounded-lg border border-gray-300 transition-colors cursor-pointer hover:bg-purple-50 hover:border-purple-300">
                                                    <input type="checkbox" class="w-4 h-4 text-purple-600 rounded question-type" value="fill_in_blank">
                                                    <span class="ml-3 text-sm font-semibold text-gray-800">📄 Fill in Blank</span>
                                                </label>
                                            </div>
                                        </div>
                                        

                                        
                                        <button type="button" onclick="generateAIQuestions()" style="color:black;"class="px-6 py-3 w-full font-semibold bg-gradient-to-r from-purple-600 to-indigo-600 rounded-lg shadow-md transition-all duration-200 text-grey-700 hover:from-purple-700 hover:to-indigo-700 hover:shadow-lg">
                                            ✨ Generate Questions
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Generate from PDF -->
                                <div class="space-y-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex justify-center items-center w-10 h-10 bg-blue-100 rounded-full">
                                            <span class="font-bold text-blue-600">2</span>
                                        </div>
                                        <h4 class="text-lg font-semibold text-gray-800">Generate from PDF</h4>
                                    </div>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block mb-2 text-sm font-medium text-gray-700">Upload PDF Document:</label>
                                            <div class="p-6 text-center rounded-lg border-2 border-gray-300 border-dashed transition-colors hover:border-blue-400">
                                                <input type="file" id="pdfFile" accept=".pdf" class="hidden">
                                                <label for="pdfFile" class="cursor-pointer">
                                                    <div class="mb-2 text-gray-400">
                                                        <svg class="mx-auto w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                                        </svg>
                                                    </div>
                                                    <p class="text-sm text-gray-600">Click to upload PDF file</p>
                                                    <p class="mt-1 text-xs text-gray-400">Maximum file size: 20MB</p>
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label class="block mb-2 text-sm font-medium text-gray-700">Instructions for PDF:</label>
                                            <textarea style="color: grey" id="pdfPrompt" rows="3" placeholder="Example: Create questions from chapter 1 about cell structure" class="px-4 py-3 w-full text-sm rounded-lg border border-gray-300 resize-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                                        </div>
                                        
                                        <button type="button" onclick="generateFromPDF()" style="color:rgb(0, 0, 0);" class="px-6 py-3 w-full font-semibold text-white bg-gradient-to-r from-blue-600 to-cyan-600 rounded-lg shadow-md transition-all duration-200 hover:from-blue-700 hover:to-cyan-700 hover:shadow-lg">
                                            📄 Process PDF
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="aiStatus" class="p-4 mt-6 font-medium text-center rounded-lg"></div>
                        </div>
                    </div>

                    <!-- Generated Questions Preview -->
                    <div id="generatedQuestions" class="mb-10" style="display: none;">
                        <div class="overflow-hidden bg-white rounded-2xl border border-gray-100 shadow-lg">
                            <div class="px-8 py-6 bg-gradient-to-r from-green-500 to-emerald-500">
                                <h3 class="flex items-center text-2xl font-bold text-white">
                                    <span class="mr-3">📝</span>
                                    Generated Questions
                                </h3>
                                <p class="mt-2 text-green-100">Review and select questions to use in your activity</p>
                            </div>
                            
                            <div class="p-8">
                                <div id="questionsList" class="space-y-6"></div>
                                
                                <div class="flex flex-col gap-4 pt-6 mt-8 border-t border-gray-200 sm:flex-row">
                                    <button type="button" onclick="useSelectedQuestions()" class="flex-1 px-6 py-3 font-semibold text-white bg-gradient-to-r from-green-600 to-emerald-600 rounded-lg shadow-md transition-all duration-200 hover:from-green-700 hover:to-emerald-700 hover:shadow-lg">
                                        ✅ Use Selected Questions
                                    </button>
                                    <button type="button" onclick="clearGenerated()" class="px-6 py-3 font-semibold text-white bg-gray-500 rounded-lg transition-all duration-200 hover:bg-gray-600">
                                        🗑️ Clear All
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.activities.store') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- Dropdown untuk memilih materi --}}
                        <div class="mb-6">
                            <label for="reading_material_id" class="block mb-2 text-sm font-semibold text-gray-800">📚 Pilih Materi Bacaan</label>
                            <select name="reading_material_id" id="reading_material_id" class="block px-4 py-3 w-full text-sm text-gray-900 rounded-lg border border-gray-300 shadow-sm bg-blue focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                                <option value="" class="text-gray-500">-- Pilih Materi --</option>
                                @foreach ($materials as $material)
                                    <option value="{{ $material->id }}" class="text-gray-900" {{ request()->query('material_id') == $material->id ? 'selected' : '' }}>
                                        {{ $material->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('reading_material_id') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        {{-- Tipe Aktivitas --}}
                        <div class="mb-6">
                            <label for="type" class="block mb-2 text-sm font-medium text-gray-700">🎯 Tipe Aktivitas</label>
                            <div class="grid grid-cols-2 gap-3 md:grid-cols-3">
                                <label class="relative">
                                    <input type="radio" name="type" value="multiple_choice" class="sr-only peer" required checked>
                                    <div class="p-4 rounded-lg border-2 border-gray-200 transition cursor-pointer peer-checked:border-indigo-500 peer-checked:bg-indigo-50 hover:bg-gray-50">
                                        <div class="text-center">
                                            <div class="mb-2 text-2xl">🔤</div>
                                            <div class="text-sm font-medium">Pilihan Ganda</div>
                                        </div>
                                    </div>
                                </label>
                                <label class="relative">
                                    <input type="radio" name="type" value="essay" class="sr-only peer">
                                    <div class="p-4 rounded-lg border-2 border-gray-200 transition cursor-pointer peer-checked:border-indigo-500 peer-checked:bg-indigo-50 hover:bg-gray-50">
                                        <div class="text-center">
                                            <div class="mb-2 text-2xl">📝</div>
                                            <div class="text-sm font-medium">Esai</div>
                                        </div>
                                    </div>
                                </label>
                                <label class="relative">
                                    <input type="radio" name="type" value="true_false" class="sr-only peer">
                                    <div class="p-4 rounded-lg border-2 border-gray-200 transition cursor-pointer peer-checked:border-indigo-500 peer-checked:bg-indigo-50 hover:bg-gray-50">
                                        <div class="text-center">
                                            <div class="mb-2 text-2xl">✅</div>
                                            <div class="text-sm font-medium">Benar/Salah</div>
                                        </div>
                                    </div>
                                </label>
                                <label class="relative">
                                    <input type="radio" name="type" value="fill_in_blank" class="sr-only peer">
                                    <div class="p-4 rounded-lg border-2 border-gray-200 transition cursor-pointer peer-checked:border-indigo-500 peer-checked:bg-indigo-50 hover:bg-gray-50">
                                        <div class="text-center">
                                            <div class="mb-2 text-2xl">📄</div>
                                            <div class="text-sm font-medium">Isian Singkat</div>
                                        </div>
                                    </div>
                                </label>
                                <label class="relative">
                                    <input type="radio" name="type" value="image_based" class="sr-only peer">
                                    <div class="p-4 rounded-lg border-2 border-gray-200 transition cursor-pointer peer-checked:border-indigo-500 peer-checked:bg-indigo-50 hover:bg-gray-50">
                                        <div class="text-center">
                                            <div class="mb-2 text-2xl">🖼️</div>
                                            <div class="text-sm font-medium">Berbasis Gambar</div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        
                        {{-- Pertanyaan --}}
                        <div class="mb-6">
                            <label for="question" class="block mb-2 text-sm font-medium text-gray-700">❓ Pertanyaan</label>
                            <textarea name="question" id="question" rows="4" class="block px-4 py-3 w-full text-gray-900 bg-white rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Masukkan pertanyaan Anda di sini..." required>{{ old('question') }}</textarea>
                        </div>

                        {{-- Opsi Jawaban (dinamis berdasarkan tipe) --}}
                        <div id="optionsSection" class="mb-6">
                            <label class="block mb-3 text-sm font-medium text-gray-700">🔤 Opsi Jawaban</label>
                            <div id="optionsList" class="space-y-2">
                                <div class="flex items-center space-x-2">
                                    <span class="flex justify-center items-center w-8 h-8 text-sm font-semibold text-blue-800 bg-blue-100 rounded-full">A</span>
                                    <input type="text" name="options[]" placeholder="Opsi A" class="flex-1 px-3 py-2 text-gray-900 bg-white rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="flex justify-center items-center w-8 h-8 text-sm font-semibold text-green-800 bg-green-100 rounded-full">B</span>
                                    <input type="text" name="options[]" placeholder="Opsi B" class="flex-1 px-3 py-2 text-gray-900 bg-white rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="flex justify-center items-center w-8 h-8 text-sm font-semibold text-yellow-800 bg-yellow-100 rounded-full">C</span>
                                    <input type="text" name="options[]" placeholder="Opsi C" class="flex-1 px-3 py-2 text-gray-900 bg-white rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="flex justify-center items-center w-8 h-8 text-sm font-semibold text-red-800 bg-red-100 rounded-full">D</span>
                                    <input type="text" name="options[]" placeholder="Opsi D" class="flex-1 px-3 py-2 text-gray-900 bg-white rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        {{-- Jawaban Benar --}}
                        <div class="mb-6">
                            <label for="correct_answer" class="block mb-2 text-sm font-medium text-gray-700">✅ Jawaban Benar</label>
                            <input type="text" name="correct_answer" id="correct_answer" placeholder="Contoh: A, atau 'Benar', atau jawaban esai" class="block px-4 py-3 w-full text-gray-900 bg-white rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        {{-- Unggah Gambar --}}
                        <div class="mb-6" id="imageSection">
                            <label for="image" class="block mb-2 text-sm font-medium text-gray-700">🖼️ Gambar (Opsional)</label>
                            <div class="p-6 text-center rounded-lg border-2 border-gray-300 border-dashed transition hover:border-indigo-400">
                                <input type="file" name="image" id="image" class="hidden" accept="image/*" onchange="previewImage(this)">
                                <label for="image" class="cursor-pointer">
                                    <div id="imagePreview" class="hidden mb-4">
                                        <img id="previewImg" class="mx-auto max-w-xs h-auto rounded-lg shadow-md">
                                        <button type="button" onclick="removeImage()" class="mt-2 px-3 py-1 text-sm text-red-600 bg-red-100 rounded hover:bg-red-200">Remove</button>
                                    </div>
                                    <div id="uploadPrompt">
                                        <div class="mb-2 text-gray-400">
                                            <svg class="mx-auto w-12 h-12" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                        <p class="text-sm text-gray-600">Click to upload image</p>
                                        <p class="text-xs text-gray-400 mt-1">JPG, PNG, GIF up to 2MB</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-between items-center pt-6 mt-8 border-t">
                            <a href="{{ url()->previous() }}" class="px-6 py-2 text-gray-600 bg-gray-100 rounded-lg transition hover:bg-gray-200">
                                ← Batal
                            </a>
                            <button type="submit" class="px-8 py-3 text-white bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg shadow-lg transition hover:from-indigo-700 hover:to-purple-700">
                                💾 Simpan Aktivitas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let generatedQuestionsData = [];
        
        // Dynamic form behavior based on question type
        document.addEventListener('DOMContentLoaded', function() {
            const typeInputs = document.querySelectorAll('input[name="type"]');
            const optionsSection = document.getElementById('optionsSection');
            
            typeInputs.forEach(input => {
                input.addEventListener('change', function() {
                    toggleOptionsSection(this.value);
                });
            });
            
            toggleOptionsSection('multiple_choice'); // Default
        });
        
        function toggleOptionsSection(type) {
            const optionsSection = document.getElementById('optionsSection');
            const correctAnswerInput = document.getElementById('correct_answer');
            const imageSection = document.getElementById('imageSection');
            
            if (type === 'multiple_choice') {
                optionsSection.style.display = 'block';
                correctAnswerInput.placeholder = 'Contoh: A, B, C, atau D';
                imageSection.style.display = 'block';
            } else if (type === 'true_false') {
                optionsSection.style.display = 'none';
                correctAnswerInput.placeholder = 'Benar atau Salah';
                imageSection.style.display = 'block';
            } else if (type === 'fill_in_blank') {
                optionsSection.style.display = 'none';
                correctAnswerInput.placeholder = 'Jawaban yang benar';
                imageSection.style.display = 'block';
            } else if (type === 'essay') {
                optionsSection.style.display = 'none';
                correctAnswerInput.placeholder = 'Poin-poin jawaban yang diharapkan';
                imageSection.style.display = 'block';
            } else if (type === 'image_based') {
                optionsSection.style.display = 'block';
                correctAnswerInput.placeholder = 'Jawaban berdasarkan gambar';
                imageSection.style.display = 'block';
            } else {
                optionsSection.style.display = 'none';
                correctAnswerInput.placeholder = 'Jawaban yang benar';
                imageSection.style.display = 'block';
            }
        }
        
        function previewImage(input) {
            if (input.files && input.files[0]) {
                // Check file size (2MB limit)
                if (input.files[0].size > 2 * 1024 * 1024) {
                    alert('File terlalu besar. Maksimal 2MB.');
                    input.value = '';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('imagePreview').classList.remove('hidden');
                    document.getElementById('uploadPrompt').classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        function removeImage() {
            document.getElementById('image').value = '';
            document.getElementById('imagePreview').classList.add('hidden');
            document.getElementById('uploadPrompt').classList.remove('hidden');
        }
        
        async function generateAIQuestions() {
            const prompt = document.getElementById('aiPrompt').value;
            const questionCount = 1; // Fixed to 1 question
            const selectedTypes = Array.from(document.querySelectorAll('.question-type:checked')).map(cb => cb.value);
            const status = document.getElementById('aiStatus');
            
            if (!prompt.trim()) {
                status.innerHTML = '<span class="text-red-600">Please enter a prompt</span>';
                return;
            }
            
            if (selectedTypes.length === 0) {
                status.innerHTML = '<span class="text-red-600">Please select at least one question type</span>';
                return;
            }
            
            status.innerHTML = '<span class="text-blue-600">🔄 Generating questions with AI...</span>';
            
            const fullPrompt = `Generate 1 educational question about: ${prompt}. 
            
Use this question type: ${selectedTypes[0] || 'multiple_choice'}.
            
Format the question as plain text with this structure:
Question: [question text]
Type: [question type]
Options: A) option1, B) option2, C) option3, D) option4 (only for multiple choice)
Answer: [correct answer]`;
            
            try {
                const response = await fetch('{{ route("admin.materials.generate-ai") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ prompt: fullPrompt, genre_id: 1 })
                });
                
                const data = await response.json();
                
                if (data.error) {
                    status.innerHTML = `<span class="text-red-600">Error: ${data.error}</span>`;
                    return;
                }
                
                // Parse questions from plain text content
                const questions = parseQuestionsFromText(data.content || data.title || 'No content generated');
                displayGeneratedQuestions(questions);
                
                status.innerHTML = '<span class="text-green-600">✅ Questions generated successfully!</span>';
                
            } catch (error) {
                status.innerHTML = `<span class="text-red-600">Network error: ${error.message}</span>`;
            }
        }
        
        async function generateFromPDF() {
            const fileInput = document.getElementById('pdfFile');
            const pdfPrompt = document.getElementById('pdfPrompt').value;
            const status = document.getElementById('aiStatus');
            
            if (!fileInput.files[0]) {
                status.innerHTML = '<span class="text-red-600">Please select a PDF file</span>';
                return;
            }
            
            if (!pdfPrompt.trim()) {
                status.innerHTML = '<span class="text-red-600">Please enter PDF instructions</span>';
                return;
            }
            
            status.innerHTML = '<span class="text-blue-600">🔄 Processing PDF...</span>';
            
            const formData = new FormData();
            formData.append('pdf_file', fileInput.files[0]);
            formData.append('prompt', pdfPrompt);
            formData.append('genre_id', 1);
            
            try {
                const response = await fetch('{{ route("admin.materials.upload-pdf") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                });
                
                const responseText = await response.text();
                let data;
                try {
                    data = JSON.parse(responseText);
                } catch (e) {
                    console.error('Response is not JSON:', responseText);
                    throw new Error('Server returned invalid response');
                }
                
                if (data.error) {
                    status.innerHTML = `<span class="text-red-600">Error: ${data.error}</span>`;
                    return;
                }
                
                // Parse content from PDF response like materials
                const questions = parseQuestionsFromText(data.content || data.title || '');
                if (questions.length > 0) {
                    displayGeneratedQuestions(questions);
                    status.innerHTML = '<span class="text-green-600">✅ Questions generated from PDF!</span>';
                } else {
                    status.innerHTML = '<span class="text-yellow-600">⚠️ No questions found in PDF response</span>';
                }
                
            } catch (error) {
                status.innerHTML = `<span class="text-red-600">Network error: ${error.message}</span>`;
            }
        }
        
        function parseQuestionsFromText(text) {
            const questions = [];
            const questionBlocks = text.split('---').filter(block => block.trim());
            
            questionBlocks.forEach(block => {
                const lines = block.trim().split('\n').filter(line => line.trim());
                const question = { type: 'multiple_choice', question: '', options: [], correct_answer: '' };
                
                lines.forEach(line => {
                    const lower = line.toLowerCase();
                    if (lower.startsWith('question:')) {
                        question.question = line.substring(9).trim();
                    } else if (lower.startsWith('type:')) {
                        question.type = line.substring(5).trim();
                    } else if (lower.startsWith('options:')) {
                        const optionsText = line.substring(8).trim();
                        question.options = optionsText.split(',').map(opt => opt.trim().replace(/^[A-D]\)\s*/, ''));
                    } else if (lower.startsWith('answer:')) {
                        question.correct_answer = line.substring(7).trim();
                    }
                });
                
                if (question.question) {
                    questions.push(question);
                }
            });
            
            // Fallback if parsing fails
            if (questions.length === 0) {
                const fallbackQuestion = text.split('\n').find(line => line.includes('?')) || text.trim();
                questions.push({
                    type: 'multiple_choice',
                    question: fallbackQuestion,
                    options: ['Option A', 'Option B', 'Option C', 'Option D'],
                    correct_answer: 'A'
                });
            }
            
            return questions;
        }
        
        function displayGeneratedQuestions(questions) {
            generatedQuestionsData = questions;
            const container = document.getElementById('generatedQuestions');
            const questionsList = document.getElementById('questionsList');
            
            questionsList.innerHTML = '';
            
            questions.forEach((q, index) => {
                const questionDiv = document.createElement('div');
                questionDiv.className = 'p-6 border-2 border-gray-200 rounded-xl bg-white shadow-sm hover:shadow-md transition-shadow';
                
                const typeColors = {
                    'multiple_choice': 'bg-blue-100 text-blue-800',
                    'essay': 'bg-green-100 text-green-800',
                    'true_false': 'bg-yellow-100 text-yellow-800',
                    'fill_in_blank': 'bg-purple-100 text-purple-800'
                };
                
                const typeIcons = {
                    'multiple_choice': '🔤',
                    'essay': '📝',
                    'true_false': '✅',
                    'fill_in_blank': '📄'
                };
                
                questionDiv.innerHTML = `
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <input type="checkbox" class="w-5 h-5 text-indigo-600 rounded question-select focus:ring-indigo-500" data-index="${index}" checked>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center mb-3 space-x-2">
                                <span class="text-lg">${typeIcons[q.type] || '❓'}</span>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full ${typeColors[q.type] || 'bg-gray-100 text-gray-800'}">
                                    ${q.type.replace('_', ' ').toUpperCase()}
                                </span>
                            </div>
                            <div class="mb-3 text-lg font-medium leading-relaxed text-gray-900">
                                ${index + 1}. ${q.question}
                            </div>
                            ${q.options && q.options.length > 0 ? `
                                <div class="mb-3">
                                    <div class="mb-2 text-sm font-medium text-gray-700">Options:</div>
                                    <div class="grid grid-cols-1 gap-1">
                                        ${q.options.map((opt, i) => `
                                            <div class="flex items-center space-x-2 text-sm text-gray-600">
                                                <span class="flex justify-center items-center w-6 h-6 text-xs font-semibold text-gray-700 bg-gray-100 rounded-full">${String.fromCharCode(65 + i)}</span>
                                                <span>${opt}</span>
                                            </div>
                                        `).join('')}
                                    </div>
                                </div>
                            ` : ''}
                            <div class="flex items-center space-x-2">
                                <span class="text-sm font-medium text-gray-700">Correct Answer:</span>
                                <span class="px-2 py-1 text-sm font-semibold text-green-800 bg-green-100 rounded">${q.correct_answer}</span>
                            </div>
                        </div>
                    </div>
                `;
                questionsList.appendChild(questionDiv);
            });
            
            container.style.display = 'block';
        }
        
        function useSelectedQuestions() {
            const selectedIndexes = Array.from(document.querySelectorAll('.question-select:checked')).map(cb => parseInt(cb.dataset.index));
            
            if (selectedIndexes.length === 0) {
                alert('Please select at least one question');
                return;
            }
            
            const firstQuestion = generatedQuestionsData[selectedIndexes[0]];
            
            // Fill form with first selected question
            document.getElementById('question').value = firstQuestion.question;
            document.getElementById('correct_answer').value = firstQuestion.correct_answer;
            
            // Set question type
            const typeInput = document.querySelector(`input[name="type"][value="${firstQuestion.type}"]`);
            if (typeInput) {
                typeInput.checked = true;
                toggleOptionsSection(firstQuestion.type);
            }
            
            // Fill options if multiple choice
            if (firstQuestion.options && firstQuestion.type === 'multiple_choice') {
                const optionInputs = document.querySelectorAll('input[name="options[]"]');
                firstQuestion.options.forEach((option, index) => {
                    if (optionInputs[index]) {
                        optionInputs[index].value = option;
                    }
                });
            }
            
            alert(`Question ${selectedIndexes[0] + 1} has been loaded into the form!`);
        }
        
        function clearGenerated() {
            document.getElementById('generatedQuestions').style.display = 'none';
            generatedQuestionsData = [];
        }
    </script>
</x-app-layout>
