<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReadingMaterial;
use App\Models\Chapter;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ReadingMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materials = ReadingMaterial::with('chapter', 'genre')->latest()->paginate(10);
        return view('admin.materials.index', compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $chapters = Chapter::all();
        $genres = Genre::all();
        return view('admin.materials.create', compact('chapters', 'genres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'chapter_id' => 'required|exists:chapters,id',
                'genre_id' => 'required|exists:genres,id',
                'illustration' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'nullable|string|max:500',
                'selected_questions' => 'nullable|string',
            ]);

            if ($request->hasFile('illustration')) {
                $validated['illustration'] = $request->file('illustration')->store('illustrations', 'public');
            }

            $material = ReadingMaterial::create($validated);
            
            // Add selected questions as activities
            if ($request->selected_questions) {
                Log::info('Selected questions received: ' . $request->selected_questions);
                $questions = json_decode($request->selected_questions, true);
                if ($questions && is_array($questions)) {
                    Log::info('Processing ' . count($questions) . ' questions');
                    foreach ($questions as $index => $question) {
                        $activity = \App\Models\HotsActivity::create([
                            'reading_material_id' => $material->id,
                            'type' => $question['type'] ?? 'multiple_choice',
                            'question' => $question['question'] ?? '',
                            'options' => isset($question['options']) ? $question['options'] : null,
                            'correct_answer' => $question['correct_answer'] ?? '',
                            'position' => $index + 1,
                        ]);
                        Log::info('Created activity: ' . $activity->id . ' - ' . $activity->question);
                    }
                } else {
                    Log::error('Questions decode failed or not array');
                }
            } else {
                Log::info('No selected questions received');
            }

            return redirect()->route('admin.materials.index')->with('success', 'Materi berhasil dibuat.');
        } catch (\Exception $e) {
            Log::error('Material Store Error: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ReadingMaterial $material)
    {
        $material->load('activities');
        return view('admin.materials.show', compact('material'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReadingMaterial $material)
    {
        $chapters = Chapter::all();
        $genres = Genre::all();
        return view('admin.materials.edit', compact('material', 'chapters', 'genres'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReadingMaterial $material)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'chapter_id' => 'required|exists:chapters,id',
            'genre_id' => 'required|exists:genres,id',
            'illustration' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('illustration')) {
            if ($material->illustration) {
                Storage::disk('public')->delete($material->illustration);
            }
            $validated['illustration'] = $request->file('illustration')->store('illustrations', 'public');
        }

        $material->update($validated);

        return redirect()->route('admin.materials.index')->with('success', 'Materi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReadingMaterial $material)
    {
        if ($material->illustration) {
            Storage::disk('public')->delete($material->illustration);
        }
        $material->delete();
        return redirect()->route('admin.materials.index')->with('success', 'Materi berhasil dihapus.');
    }

    /**
     * Handle image upload for TinyMCE editor
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $path = $request->file('file')->store('editor-images', 'public');
        $url = asset('storage/' . $path);

        return response()->json(['location' => $url]);
    }

    public function generateWithAI(Request $request)
    {
        $request->headers->set('Accept', 'application/json');
        
        try {
            $validated = $request->validate([
                'prompt' => 'required|string|max:1000',
                'genre_id' => 'required|integer|exists:genres,id',
            ]);

            $genre = Genre::find($validated['genre_id']);
            
            if (!$genre) {
                return response()->json(['error' => 'Genre not found'], 404);
            }
            
            $enhancedPrompt = $validated['prompt'] . '. Also generate 5 related questions with different types (multiple choice, essay, true/false, fill in blank). Format as JSON with "title", "content", and "questions" array where each question has: type, question, options (for multiple choice), correct_answer.';
            
            $aiService = new \App\Services\AIContentService();
            $result = $aiService->generateFromPrompt($enhancedPrompt, $genre->name);
            
            if (isset($result['error'])) {
                return response()->json(['error' => $result['error']], 500);
            }

            return response()->json([
                'title' => $result['title'] ?? 'Generated Content',
                'content' => $result['content'] ?? '<p>Content generation failed</p>',
                'questions' => $result['questions'] ?? []
            ]);
        } catch (\Exception $e) {
            Log::error('AI Generation Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function uploadPDF(Request $request)
    {
        $request->headers->set('Accept', 'application/json');
        
        try {
            $validated = $request->validate([
                'pdf_file' => 'required|file|mimes:pdf|max:51200',
                'genre_id' => 'required|integer|exists:genres,id',
                'prompt' => 'required|string|max:500',
            ]);

            $file = $request->file('pdf_file');
            $genre = Genre::find($validated['genre_id']);
            
            if (!$genre) {
                return response()->json(['error' => 'Genre not found'], 404);
            }

            // Process PDF with Gemini's native PDF support
            $pdfContent = file_get_contents($file->getRealPath());
            $base64Pdf = base64_encode($pdfContent);
            
            $aiService = new \App\Services\AIContentService();
            $result = $aiService->processPDFWithPrompt($base64Pdf, $validated['prompt'], $genre->name);
            
            if (isset($result['error'])) {
                return response()->json(['error' => $result['error']], 500);
            }

            return response()->json([
                'title' => $result['title'] ?? 'Generated from PDF',
                'content' => $result['content'] ?? '<p>PDF processing failed</p>',
                'questions' => $result['questions'] ?? []
            ]);
        } catch (\Exception $e) {
            Log::error('PDF Upload Error: ' . $e->getMessage());
            return response()->json(['error' => 'PDF processing failed: ' . $e->getMessage()], 500);
        }
    }

    private function extractPDFText(string $filePath): string
    {
        try {
            // Simple text extraction from PDF
            $content = file_get_contents($filePath);
            
            // Extract text between parentheses (basic PDF text extraction)
            preg_match_all('/\(([^)]+)\)/', $content, $matches);
            $text = implode(' ', $matches[1] ?? []);
            
            // Clean up the text
            $text = preg_replace('/[^\w\s.,!?-]/', ' ', $text);
            $text = preg_replace('/\s+/', ' ', $text);
            
            return trim($text) ?: 'Unable to extract readable text from PDF';
        } catch (\Exception $e) {
            Log::error('PDF extraction error: ' . $e->getMessage());
            return 'PDF text extraction failed';
        }
    }

    public function testAI()
    {
        $aiService = new \App\Services\AIContentService();
        $result = $aiService->generateMaterialContent('test topic', 'narrative');
        
        return response()->json([
            'api_key_configured' => !empty(env('GEMINI_API_KEY')),
            'api_key_length' => strlen(env('GEMINI_API_KEY') ?? ''),
            'result' => $result
        ]);
    }
}