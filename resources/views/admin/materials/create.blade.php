<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Tambah Materi Bacaan Baru
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.materials.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Judul</label>
                            <input type="text" name="title" id="title" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                            @error('title') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="illustration" class="block text-sm font-medium text-gray-700">Ilustrasi (Opsional)</label>
                            <input type="file" name="illustration" id="illustration" class="block mt-1 w-full">
                            @error('illustration') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <!-- AI Generation Section -->
                        <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                            <h3 class="text-lg font-semibold text-blue-800 mb-4">🤖 AI Content Generator</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Generate from Prompt</label>
                                    <div class="space-y-2">
                                        <textarea id="aiPrompt" rows="3" placeholder="Enter detailed prompt (e.g., Create educational material about photosynthesis for high school students...)" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 resize-y"></textarea>
                                        <button type="button" onclick="generateAIContent()" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Generate Content</button>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload PDF</label>
                                    <div class="space-y-2">
                                        <input type="file" id="pdfFile" accept=".pdf" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                        <textarea id="pdfPrompt" rows="3" placeholder="Instruksi untuk PDF (contoh: rangkum bab 1, buat soal tentang descriptive text, dll)" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 resize-y"></textarea>
                                        <button type="button" onclick="uploadPDF()" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Process PDF</button>
                                    </div>
                                </div>
                            </div>
                            <div id="aiStatus" class="mt-3 text-sm text-gray-600"></div>
                        </div>

                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-gray-700">Konten</label>
                            <textarea name="content" id="content" style="display:none;">{{ old('content') }}</textarea>
                            <div id="quill-editor" style="height: 400px; border: 1px solid #d1d5db; border-radius: 0.375rem;"></div>
                            @error('content') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <!-- AI Generated Questions Section -->
                        <div id="aiQuestions" class="mb-4" style="display: none;">
                            <h3 class="text-lg font-semibold text-gray-800 mb-3">🎯 AI Generated Questions</h3>
                            <div id="questionsList" class="space-y-3"></div>
                            <button type="button" onclick="addQuestionsToMaterial()" class="mt-3 px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">Add Questions to Material</button>
                        </div>

                        <div class="mb-4">
                            <label for="chapter_id" class="block text-sm font-medium text-gray-700">Bab</label>
                            <select name="chapter_id" id="chapter_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm">
                                @foreach ($chapters as $chapter)
                                    <option value="{{ $chapter->id }}">{{ $chapter->title }}</option>
                                @endforeach
                            </select>
                            @error('chapter_id') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="genre_id" class="block text-sm font-medium text-gray-700">Genre</label>
                            <select name="genre_id" id="genre_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm">
                                @foreach ($genres as $genre)
                                    <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                                @endforeach
                            </select>
                            @error('genre_id') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-gray-800 rounded-md border border-transparent hover:bg-gray-700">Simpan Materi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let generatedQuestions = [];
        
        async function generateAIContent() {
            const prompt = document.getElementById('aiPrompt').value;
            const genreId = document.getElementById('genre_id').value;
            const status = document.getElementById('aiStatus');
            
            if (!prompt.trim()) {
                status.textContent = 'Please enter a prompt';
                status.className = 'mt-3 text-sm text-red-600';
                return;
            }
            
            status.textContent = 'Generating content with AI...';
            status.className = 'mt-3 text-sm text-blue-600';
            
            console.log('Sending data:', { prompt, genre_id: genreId });
            
            try {
                const response = await fetch('{{ route("admin.materials.generate-ai") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ prompt, genre_id: genreId })
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
                    status.textContent = 'Error: ' + data.error;
                    status.className = 'mt-3 text-sm text-red-600';
                    return;
                }
                
                // Update form fields
                document.getElementById('title').value = data.title;
                document.getElementById('content').value = data.content;
                
                status.textContent = 'Content generated successfully!';
                status.className = 'mt-3 text-sm text-green-600';
                
            } catch (error) {
                console.error('AI Generation Error:', error);
                status.textContent = 'Network error: ' + error.message;
                status.className = 'mt-3 text-sm text-red-600';
            }
        }
        
        async function uploadPDF() {
            const fileInput = document.getElementById('pdfFile');
            const promptInput = document.getElementById('pdfPrompt');
            const genreId = document.getElementById('genre_id').value;
            const status = document.getElementById('aiStatus');
            
            if (!fileInput.files[0]) {
                status.textContent = 'Please select a PDF file';
                status.className = 'mt-3 text-sm text-red-600';
                return;
            }
            
            if (!promptInput.value.trim()) {
                status.textContent = 'Please enter instruction for PDF processing';
                status.className = 'mt-3 text-sm text-red-600';
                return;
            }
            
            status.textContent = 'Processing PDF with your instruction...';
            status.className = 'mt-3 text-sm text-blue-600';
            
            const formData = new FormData();
            formData.append('pdf_file', fileInput.files[0]);
            formData.append('genre_id', genreId);
            formData.append('prompt', promptInput.value.trim());
            
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
                    status.textContent = 'Error: ' + data.error;
                    status.className = 'mt-3 text-sm text-red-600';
                    return;
                }
                
                // Update form fields
                document.getElementById('title').value = data.title;
                document.getElementById('content').value = data.content;
                
                // Show generated questions
                if (data.questions && data.questions.length > 0) {
                    generatedQuestions = data.questions;
                    displayQuestions(data.questions);
                }
                
                status.textContent = 'PDF processed successfully!';
                status.className = 'mt-3 text-sm text-green-600';
                
            } catch (error) {
                console.error('PDF Upload Error:', error);
                status.textContent = 'Network error: ' + error.message;
                status.className = 'mt-3 text-sm text-red-600';
            }
        }
        
        function displayQuestions(questions) {
            const questionsContainer = document.getElementById('aiQuestions');
            const questionsList = document.getElementById('questionsList');
            
            questionsList.innerHTML = '';
            
            questions.forEach((q, index) => {
                const questionDiv = document.createElement('div');
                questionDiv.className = 'p-3 bg-gray-50 rounded-lg border';
                questionDiv.innerHTML = `
                    <div class="font-medium text-gray-800">${index + 1}. ${q.question}</div>
                    <div class="text-sm text-gray-600 mt-1">Type: ${q.type}</div>
                    ${q.options ? `<div class="text-sm text-gray-600">Options: ${Object.values(q.options).join(', ')}</div>` : ''}
                    <div class="text-sm text-green-600 mt-1">Answer: ${q.correct_answer}</div>
                `;
                questionsList.appendChild(questionDiv);
            });
            
            questionsContainer.style.display = 'block';
        }
        
        function addQuestionsToMaterial() {
            // This would typically save questions to the material
            // For now, just show success message
            alert('Questions will be added to the material after saving!');
        }
    </script>

    <!-- Quill.js CDN -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    
    <script>
        // Initialize Quill editor
        var quill = new Quill('#quill-editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'font': [] }],
                    [{ 'align': [] }],
                    ['blockquote', 'code-block'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    ['link', 'image', 'video'],
                    ['clean']
                ]
            },
            placeholder: 'Enter your content here...'
        });

        // Sync Quill content with hidden textarea
        quill.on('text-change', function() {
            document.getElementById('content').value = quill.root.innerHTML;
        });

        // Set initial content if editing
        @if(old('content'))
            quill.root.innerHTML = {!! json_encode(old('content')) !!};
        @endif

        // Update AI generation to work with Quill
        function updateQuillContent(content) {
            quill.root.innerHTML = content;
            document.getElementById('content').value = content;
        }

        // Override the content update in AI functions
        const originalGenerateAI = generateAIContent;
        generateAIContent = async function() {
            const prompt = document.getElementById('aiPrompt').value;
            const genreId = document.getElementById('genre_id').value;
            const status = document.getElementById('aiStatus');
            
            if (!prompt.trim()) {
                status.textContent = 'Please enter a prompt';
                status.className = 'mt-3 text-sm text-red-600';
                return;
            }
            
            status.textContent = 'Generating content with AI...';
            status.className = 'mt-3 text-sm text-blue-600';
            
            try {
                const response = await fetch('{{ route("admin.materials.generate-ai") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ prompt, genre_id: genreId })
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
                    status.textContent = 'Error: ' + data.error;
                    status.className = 'mt-3 text-sm text-red-600';
                    return;
                }
                
                // Update form fields
                document.getElementById('title').value = data.title;
                updateQuillContent(data.content);
                
                status.textContent = 'Content generated successfully!';
                status.className = 'mt-3 text-sm text-green-600';
                
            } catch (error) {
                console.error('AI Generation Error:', error);
                status.textContent = 'Network error: ' + error.message;
                status.className = 'mt-3 text-sm text-red-600';
            }
        };

        // Override PDF upload function
        const originalUploadPDF = uploadPDF;
        uploadPDF = async function() {
            const fileInput = document.getElementById('pdfFile');
            const promptInput = document.getElementById('pdfPrompt');
            const genreId = document.getElementById('genre_id').value;
            const status = document.getElementById('aiStatus');
            
            if (!fileInput.files[0]) {
                status.textContent = 'Please select a PDF file';
                status.className = 'mt-3 text-sm text-red-600';
                return;
            }
            
            if (!promptInput.value.trim()) {
                status.textContent = 'Please enter instruction for PDF processing';
                status.className = 'mt-3 text-sm text-red-600';
                return;
            }
            
            status.textContent = 'Processing PDF with your instruction...';
            status.className = 'mt-3 text-sm text-blue-600';
            
            const formData = new FormData();
            formData.append('pdf_file', fileInput.files[0]);
            formData.append('genre_id', genreId);
            formData.append('prompt', promptInput.value.trim());
            
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
                    status.textContent = 'Error: ' + data.error;
                    status.className = 'mt-3 text-sm text-red-600';
                    return;
                }
                
                // Update form fields
                document.getElementById('title').value = data.title;
                updateQuillContent(data.content);
                
                // Show generated questions
                if (data.questions && data.questions.length > 0) {
                    generatedQuestions = data.questions;
                    displayQuestions(data.questions);
                }
                
                status.textContent = 'PDF processed successfully!';
                status.className = 'mt-3 text-sm text-green-600';
                
            } catch (error) {
                console.error('PDF Upload Error:', error);
                status.textContent = 'Network error: ' + error.message;
                status.className = 'mt-3 text-sm text-red-600';
            }
        };
    </script>
</x-app-layout>