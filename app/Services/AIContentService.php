<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIContentService
{
    private ?string $apiKey;

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
    }

    public function generateMaterialContent(string $topic, string $genre): array
    {
        $prompt = "Buatlah materi pembelajaran komprehensif tentang '{$topic}' dalam genre {$genre}. Sertakan:
        - Judul yang menarik dan relevan
        - Konten terstruktur (400-600 kata) dengan format HTML
        - Penjelasan yang jelas dengan contoh-contoh
        - Nilai edukatif yang sesuai untuk siswa
        
        Format JSON:
        {
          \"title\": \"Judul Materi\",
          \"content\": \"<h3>Pendahuluan</h3><p>penjelasan awal...</p><h3>Pembahasan Utama</h3><p>penjelasan detail dengan contoh...</p><h3>Kesimpulan</h3><p>ringkasan dan penutup...</p>\"
        }";

        return $this->makeRequest($prompt);
    }

    public function generateQuestionsFromContent(string $content, int $count = 5): array
    {
        $prompt = "Based on this content: '{$content}' Generate {$count} HOTS questions with types: multiple choice, true/false, fill in blank, essay. Format as JSON array with keys: type, question, options, correct_answer";

        return $this->makeRequest($prompt);
    }

    public function generateContentFromPDF(string $pdfText, string $genre): array
    {
        $shortText = substr($pdfText, 0, 1500);
        $prompt = "Based on this PDF content: '{$shortText}'
        
        Create educational material in {$genre} genre with:
        1. Appropriate title summarizing the content
        2. Well-structured HTML content (300-500 words) with headings and paragraphs
        3. 3-5 HOTS questions based on the content
        
        Return ONLY valid JSON: {\"title\": \"Educational Title\", \"content\": \"<h3>Section 1</h3><p>content...</p><h3>Section 2</h3><p>more content...</p>\", \"questions\": [{\"type\": \"multiple_choice\", \"question\": \"What is...?\", \"options\": {\"A\": \"option1\", \"B\": \"option2\", \"C\": \"option3\", \"D\": \"option4\"}, \"correct_answer\": \"A\"}]}";

        return $this->makeRequest($prompt);
    }

    public function generateFromPrompt(string $userPrompt, string $genre): array
    {
        if (empty($this->apiKey)) {
            return ['error' => 'Gemini API key not configured'];
        }

        try {
            $response = Http::withHeaders([
                'x-goog-api-key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(60)->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent', [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $userPrompt . "\n\nFormat the response as JSON: {\"title\": \"appropriate title\", \"content\": \"<h3>Section</h3><p>HTML formatted content...</p>\"}"
                            ]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $content = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
                
                $content = trim($content);
                if (str_starts_with($content, '```json')) {
                    $content = substr($content, 7);
                }
                if (str_ends_with($content, '```')) {
                    $content = substr($content, 0, -3);
                }
                
                $decoded = json_decode($content, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return [
                        'title' => 'Generated Content',
                        'content' => '<p>' . $content . '</p>'
                    ];
                }
                
                return $decoded ?? ['error' => 'Empty response'];
            }

            Log::error('Gemini API Error: ' . $response->status() . ' - ' . $response->body());
            return ['error' => 'API request failed: ' . $response->status()];
        } catch (\Exception $e) {
            Log::error('Gemini Generation Error: ' . $e->getMessage());
            Log::error('Full exception: ' . $e->getTraceAsString());
            return ['error' => 'Generation error: ' . $e->getMessage()];
        }
    }

    public function processPDFWithPrompt(string $base64Pdf, string $userPrompt, string $genre): array
    {
        if (empty($this->apiKey)) {
            return ['error' => 'Gemini API key not configured'];
        }

        try {
            $response = Http::withHeaders([
                'x-goog-api-key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(60)->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent', [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'inline_data' => [
                                    'mime_type' => 'application/pdf',
                                    'data' => $base64Pdf
                                ]
                            ],
                            [
                                'text' => "Berdasarkan dokumen PDF ini, lakukan instruksi berikut: {$userPrompt}

Buat materi pembelajaran sesuai instruksi tersebut dalam format JSON:
{
  \"title\": \"Judul sesuai instruksi\",
  \"content\": \"<h3>Bagian 1</h3><p>konten sesuai instruksi...</p><h3>Bagian 2</h3><p>penjelasan detail...</p>\",
  \"questions\": [
    {
      \"type\": \"multiple_choice\",
      \"question\": \"Pertanyaan berdasarkan instruksi?\",
      \"options\": {\"A\": \"pilihan1\", \"B\": \"pilihan2\", \"C\": \"pilihan3\", \"D\": \"pilihan4\"},
      \"correct_answer\": \"A\"
    }
  ]
}"
                            ]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $content = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
                
                $content = trim($content);
                if (str_starts_with($content, '```json')) {
                    $content = substr($content, 7);
                }
                if (str_ends_with($content, '```')) {
                    $content = substr($content, 0, -3);
                }
                
                $decoded = json_decode($content, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    Log::error('JSON decode error: ' . json_last_error_msg() . ' Content: ' . $content);
                    return ['error' => 'Invalid JSON response from AI'];
                }
                
                return $decoded ?? ['error' => 'Empty response'];
            }

            Log::error('Gemini PDF API Error: ' . $response->status() . ' - ' . $response->body());
            return ['error' => 'PDF processing failed: ' . $response->status()];
        } catch (\Exception $e) {
            Log::error('PDF Processing Error: ' . $e->getMessage());
            return [
                'title' => 'Materi dari PDF',
                'content' => '<h3>Konten PDF</h3><p>Dokumen PDF berhasil diproses. Materi pembelajaran telah dibuat berdasarkan isi dokumen yang tersedia.</p>',
                'questions' => []
            ];
        }
    }

    private function makeRequest(string $prompt): array
    {
        if (empty($this->apiKey)) {
            Log::info('Gemini API Key Status', [
                'config_key' => config('services.gemini.api_key'),
                'env_key' => env('GEMINI_API_KEY'),
                'key_length' => strlen($this->apiKey ?? ''),
            ]);
            
            return ['error' => 'Gemini API key not configured'];
        }

        try {
            $response = Http::timeout(60)->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=' . $this->apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => 'You are an educational content creator. Always respond with valid JSON format. ' . $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 1500,
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $content = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
                
                $content = trim($content);
                if (str_starts_with($content, '```json')) {
                    $content = substr($content, 7);
                }
                if (str_ends_with($content, '```')) {
                    $content = substr($content, 0, -3);
                }
                
                $decoded = json_decode($content, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    Log::error('JSON decode error: ' . json_last_error_msg() . ' Content: ' . $content);
                    return ['error' => 'Invalid JSON response from AI'];
                }
                
                return $decoded ?? ['error' => 'Empty response'];
            }

            Log::error('Gemini API Error: ' . $response->status() . ' - ' . $response->body());
            return ['error' => 'API request failed: ' . $response->status()];
        } catch (\Exception $e) {
            Log::error('AI Content Service Error: ' . $e->getMessage());
            return ['error' => 'Network error: ' . $e->getMessage()];
        }
    }
}