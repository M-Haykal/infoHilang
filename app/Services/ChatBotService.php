<?php

namespace App\Services;

use App\Models\BarangHilang;
use App\Models\HewanHilang;
use App\Models\OrangHilang;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ChatbotService
{
    protected $geminiService;
    protected $animals = [];

    protected $allowedScopes = [
        'barang_hilang' => [
            'model' => BarangHilang::class,
            'fields' => ['nama_barang', 'jenis_barang', 'merk_barang', 'lokasi_terakhir_dilihat', 'status', 'tanggal_terakhir_dilihat'],
            'description' => 'Data barang yang hilang atau ditemukan'
        ],
        'hewan_hilang' => [
            'model' => HewanHilang::class,
            'fields' => ['nama_hewan', 'jenis_hewan', 'ras', 'lokasi_terakhir_dilihat', 'status', 'tanggal_terakhir_dilihat'],
            'description' => 'Data hewan peliharaan yang hilang atau ditemukan'
        ],
        'orang_hilang' => [
            'model' => OrangHilang::class,
            'fields' => ['nama_orang', 'umur', 'jenis_kelamin', 'lokasi_terakhir_dilihat', 'status', 'tanggal_terakhir_dilihat'],
            'description' => 'Data orang yang hilang atau dicari'
        ]
    ];

    // Greeting variations untuk variasi
    protected $greetings = [
        'Halo! 👋',
        'Hai! 😊',
        'Selamat datang! 🙏',
        'Halo kak! 👋',
    ];

    // Closing variations
    protected $closings = [
        'Semoga membantu! 🙏',
        'Ada lagi yang bisa saya bantu? 😊',
        'Silakan tanya lagi jika perlu! 👋',
        'Semoga yang hilang cepat ketemu! 🤲',
    ];

    public function __construct(GeminiConnectService $geminiService)
    {
        $this->geminiService = $geminiService;
        $this->loadAnimals();
    }

    protected function loadAnimals(): void
    {
        $path = public_path('json/animals.json');
        if (File::exists($path)) {
            $this->animals = json_decode(File::get($path), true) ?? [];
        }
    }

    /**
     * MAIN ENTRY POINT
     */
    public function processMessage(string $message, ?int $userId = null): array
    {
        try {
            $message = strtolower(trim($message));
            Log::info('[CHATBOT] Start', ['message' => $message]);

            $intent = $this->detectIntent($message);
            Log::info('[CHATBOT] Intent', $intent);

            if (!$intent['is_valid']) {
                return $this->handoverToAdmin($message, $userId, 'Invalid intent');
            }

            $contextData = $this->fetchDatabaseData($intent);
            $totalRecords = collect($contextData)->sum('count');
            Log::info('[CHATBOT] Data fetched', ['total' => $totalRecords]);

            $response = $this->generateResponse($message, $contextData, $intent);
            Log::info('[CHATBOT] Response generated', ['response' => substr($response, 0, 100)]);

            return $this->successResponse($response, 'ai', $intent, $contextData);

        } catch (\Exception $e) {
            Log::error('[CHATBOT] Error', ['error' => $e->getMessage()]);
            return $this->handoverToAdmin($message, $userId, 'Error: ' . $e->getMessage());
        }
    }

    /**
     * DETEKSI INTENT
     */
    protected function detectIntent(string $message): array
    {
        $scopes = [];
        $intentType = null;
        $keyword = null;
        $location = null;

        // Kategori
        if (preg_match('/\b(barang|laptop|hp|handphone|dompet|tas|sepeda|motor|mobil|kunci|jam)\b/i', $message)) {
            $scopes[] = 'barang_hilang';
        }

        if (preg_match('/\b(hewan|binatang|peliharaan|kucing|anjing|kelinci|hamster|burung|ikan)\b/i', $message) || $this->containsAnimal($message)) {
            $scopes[] = 'hewan_hilang';
        }

        if (preg_match('/\b(orang|manusia|anak|bayi|bapak|ibu|nenek|kakek)\b/i', $message)) {
            $scopes[] = 'orang_hilang';
        }

        // Intent
        if (preg_match('/\b(cari|temukan|siapa|ada|lihat|dimana|mencari)\b/i', $message)) {
            $intentType = 'search';
            $keyword = $this->extractKeyword($message);
        } elseif (preg_match('/\b(berapa|jumlah|total|count|banyaknya|ada berapa)\b/i', $message)) {
            $intentType = 'count';
        } elseif (preg_match('/\b(statistik|ringkasan|rekap|summary|data)\b/i', $message)) {
            $intentType = 'statistics';
        }

        // Extract location
        if (preg_match('/\b(di|lokasi|area|kota|daerah|tempat)\s+([a-zA-Z\s]{3,30})\b/i', $message, $m)) {
            $location = trim($m[2]);
        }

        // Default scope
        if (empty($scopes) && $intentType) {
            $scopes = array_keys($this->allowedScopes);
        }

        return [
            'is_valid' => !empty($scopes) && $intentType,
            'scopes' => array_unique($scopes),
            'intent_type' => $intentType,
            'keyword' => $keyword,
            'location' => $location,
            'original_message' => $message,
            'confidence' => $this->calculateConfidence($scopes, $intentType, $keyword)
        ];
    }

    protected function containsAnimal(string $message): bool
    {
        foreach ($this->animals as $animal) {
            if (str_contains($message, strtolower($animal)))
                return true;
        }
        return false;
    }

    protected function extractKeyword(string $message): ?string
    {
        // "cari barang laptop" -> "laptop"
        // "cari kucing di Jakarta" -> "kucing"
        if (preg_match('/cari\s+(?:barang|hewan|orang)?\s+([a-zA-Z0-9\s\-]{2,30}?)(?:\s+di|\s+yang|$)/i', $message, $m)) {
            return trim($m[1]);
        }
        if (preg_match('/cari\s+(?:barang|hewan|orang)?\s+([a-zA-Z0-9\s\-]{2,30})/i', $message, $m)) {
            return trim($m[1]);
        }
        return null;
    }

    protected function calculateConfidence(array $scopes, ?string $intentType, ?string $keyword): float
    {
        $score = 0;
        if (!empty($scopes))
            $score += 0.4;
        if ($intentType)
            $score += 0.3;
        if ($keyword)
            $score += 0.2;
        return min($score, 1.0);
    }

    /**
     * FETCH DATA
     */
    protected function fetchDatabaseData(array $intent): array
    {
        $data = [];

        foreach ($intent['scopes'] as $scopeKey) {
            try {
                $config = $this->allowedScopes[$scopeKey];
                $model = $config['model'];

                $query = $model::query()->select($config['fields']);

                // Filter keyword
                if ($intent['keyword']) {
                    $field = $this->getSearchField($scopeKey);
                    $query->where($field, 'like', "%{$intent['keyword']}%");
                }

                // Filter location
                if ($intent['location']) {
                    $query->where('lokasi_terakhir_dilihat', 'like', "%{$intent['location']}%");
                }

                $records = $query->latest()->limit(10)->get();

                $data[$scopeKey] = [
                    'count' => $records->count(),
                    'records' => $records->toArray()
                ];

            } catch (\Exception $e) {
                Log::error("Fetch error: {$scopeKey}", ['error' => $e->getMessage()]);
                $data[$scopeKey] = ['count' => 0, 'records' => []];
            }
        }

        return $data;
    }

    protected function getSearchField(string $scope): string
    {
        return [
            'barang_hilang' => 'nama_barang',
            'hewan_hilang' => 'nama_hewan',
            'orang_hilang' => 'nama_orang'
        ][$scope] ?? 'id';
    }

    /**
     * GENERATE RESPONSE - dengan bahasa natural
     */
    protected function generateResponse(string $message, array $contextData, array $intent): string
    {
        $total = collect($contextData)->sum('count');
        $greeting = $this->getRandomGreeting();

        // TIDAK DITEMUKAN - bahasa yang lebih empathy
        if ($total === 0) {
            return $this->generateNotFoundResponse($intent, $greeting);
        }

        // ADA DATA - coba AI dulu
        try {
            $prompt = $this->buildNaturalPrompt($message, $contextData, $intent, $greeting);
            $aiResponse = $this->geminiService->generateContent($prompt);

            if (!empty($aiResponse) && strlen($aiResponse) > 10 && !str_contains(strtoupper($aiResponse), 'ADMIN_HANDOVER')) {
                return $aiResponse;
            }

            throw new \Exception('AI response invalid');

        } catch (\Exception $e) {
            Log::warning('AI failed, using natural template', ['error' => $e->getMessage()]);
            return $this->generateNaturalTemplateResponse($contextData, $intent, $greeting);
        }
    }

    /**
     * Response ketika tidak ditemukan - lebih empathy
     */
    protected function generateNotFoundResponse(array $intent, string $greeting): string
    {
        $keyword = $intent['keyword'] ?? null;
        $location = $intent['location'] ?? null;

        $parts = [$greeting];

        if ($keyword && $location) {
            $parts[] = "Maaf ya, saya belum menemukan data '{$keyword}' di area {$location} 🙏";
        } elseif ($keyword) {
            $parts[] = "Maaf ya, saya belum menemukan data '{$keyword}' di sistem kami 😔";
        } elseif ($location) {
            $parts[] = "Belum ada laporan kehilangan di {$location} saat ini 🙏";
        } else {
            $parts[] = "Saat ini belum ada data yang sesuai dengan pencarian Anda 🙏";
        }

        $parts[] = "Coba kata kunci lain seperti nama barang, jenis hewan, atau lokasi berbeda ya! 🔍";
        $parts[] = $this->getRandomClosing();

        return implode("\n\n", $parts);
    }

    /**
     * Template response yang lebih natural
     */
    protected function generateNaturalTemplateResponse(array $contextData, array $intent, string $greeting): string
    {
        $total = collect($contextData)->sum('count');
        $parts = [$greeting];

        if ($intent['intent_type'] === 'count') {
            $parts[] = $this->formatCountResponse($contextData, $total);
        } else {
            $parts[] = $this->formatSearchResponse($contextData, $total, $intent);
        }

        $parts[] = $this->getRandomClosing();

        return implode("\n\n", $parts);
    }

    /**
     * Format response untuk count
     */
    protected function formatCountResponse(array $contextData, int $total): string
    {
        if ($total === 0) {
            return "Saat ini belum ada laporan kehilangan di sistem kami 📋";
        }

        $lines = ["Saat ini ada **{$total} laporan kehilangan** di sistem kami 📊"];

        foreach ($contextData as $scope => $info) {
            if ($info['count'] === 0)
                continue;

            $name = str_replace('_hilang', '', $scope);
            $emoji = ['barang' => '📦', 'hewan' => '🐾', 'orang' => '👤'][$name] ?? '📋';
            $label = ['barang' => 'Barang', 'hewan' => 'Hewan', 'orang' => 'Orang'][$name] ?? $name;

            // Status breakdown
            $model = $this->allowedScopes[$scope]['model'];
            $hilang = $model::where('status', 'like', '%Hilang%')->count();
            $ditemukan = $model::where('status', 'like', '%Ditemukan%')->count();

            $lines[] = "{$emoji} **{$label}**: {$info['count']} total ({$hilang} hilang, {$ditemukan} ditemukan)";
        }

        return implode("\n", $lines);
    }

    /**
     * Format response untuk search
     */
    protected function formatSearchResponse(array $contextData, int $total, array $intent): string
    {
        $keyword = $intent['keyword'] ?? null;
        $location = $intent['location'] ?? null;

        $header = "Saya menemukan **{$total} laporan**";
        if ($keyword)
            $header .= " terkait '{$keyword}'";
        if ($location)
            $header .= " di {$location}";
        $header .= " 🔍";

        $lines = [$header];

        foreach ($contextData as $scope => $info) {
            if ($info['count'] === 0)
                continue;

            $name = str_replace('_hilang', '', $scope);
            $emoji = ['barang' => '📦', 'hewan' => '🐾', 'orang' => '👤'][$name] ?? '📋';
            $label = ['barang' => 'Barang', 'hewan' => 'Hewan', 'orang' => 'Orang'][$name] ?? $name;

            $lines[] = "\n{$emoji} **{$label}** ({$info['count']} data):";

            foreach (array_slice($info['records'], 0, 3) as $i => $r) {
                $itemName = $r['nama_barang'] ?? $r['nama_hewan'] ?? $r['nama_orang'] ?? 'Tidak bernama';
                $itemLoc = $r['lokasi_terakhir_dilihat'] ?? 'Lokasi tidak diketahui';
                $itemStatus = $r['status'] ?? 'Status tidak diketahui';

                $statusEmoji = str_contains(strtolower($itemStatus), 'hilang') ? '🆘' : '✅';

                $lines[] = ($i + 1) . ". **{$itemName}**";
                $lines[] = "   📍 {$itemLoc} | {$statusEmoji} {$itemStatus}";
            }

            if ($info['count'] > 3) {
                $sisa = $info['count'] - 3;
                $lines[] = "... dan {$sisa} laporan lainnya 📋";
            }
        }

        $lines[] = "\n💡 *Klik detail laporan untuk melihat foto dan info lengkap ya!*";

        return implode("\n", $lines);
    }

    /**
     * BUILD PROMPT dengan bahasa natural
     */
    protected function buildNaturalPrompt(string $message, array $contextData, array $intent, string $greeting): string
    {
        $contextText = "";
        foreach ($contextData as $scope => $info) {
            if ($info['count'] === 0)
                continue;

            $name = str_replace('_hilang', '', $scope);
            $contextText .= "\n[" . ucfirst($name) . " - {$info['count']} data]\n";

            foreach (array_slice($info['records'], 0, 5) as $r) {
                $nama = $r['nama_barang'] ?? $r['nama_hewan'] ?? $r['nama_orang'] ?? 'Unknown';
                $lokasi = $r['lokasi_terakhir_dilihat'] ?? 'Unknown';
                $status = $r['status'] ?? 'Unknown';
                $contextText .= "- {$nama}, lokasi: {$lokasi}, status: {$status}\n";
            }
        }

        $closing = $this->getRandomClosing();

        return "Kamu adalah asisten virtual InfoHilang yang ramah dan helpful. Gaya bicara santai seperti teman, gunakan emoji yang relevan.

ATURAN:
1. Selalu mulai dengan sapaan: {$greeting}
2. Jawab berdasarkan data yang diberikan saja
3. Jelaskan dengan singkat dan jelas
4. Akhiri dengan: {$closing}
5. Maksimal 4 kalimat per paragraf
6. Gunakan format: **nama** untuk highlight penting

DATA:
{$contextText}

PERTANYAAN USER: \"{$message}\"

JAWABAN (Bahasa Indonesia, gaya santai, ramah):";
    }

    /**
     * Get random greeting
     */
    protected function getRandomGreeting(): string
    {
        return $this->greetings[array_rand($this->greetings)];
    }

    /**
     * Get random closing
     */
    protected function getRandomClosing(): string
    {
        return $this->closings[array_rand($this->closings)];
    }

    /**
     * HANDOVER KE ADMIN
     */
    protected function handoverToAdmin(string $message, ?int $userId, string $reason): array
    {
        Log::info('Handover', ['reason' => $reason]);

        $adminNumber = env('ADMIN_WHATSAPP', '6281234567890');
        $greeting = $this->getRandomGreeting();

        return [
            'success' => true,
            'message' => "{$greeting}\n\nMaaf ya, untuk pertanyaan ini saya belum bisa membantu 😔\n\nSaya akan menghubungkan Anda dengan admin kami yang lebih berpengalaman. Mohon tunggu sebentar ya! 🙏",
            'intent' => 'handover',
            'source' => 'admin',
            'handover' => true,
            'reason' => $reason,
            'whatsapp_link' => "https://wa.me/{$adminNumber}?text=" . urlencode("Halo admin InfoHilang, saya butuh bantuan: {$message}"),
            'data' => []
        ];
    }

    /**
     * SUCCESS
     */
    protected function successResponse(string $message, string $source, array $intent, array $data): array
    {
        return [
            'success' => true,
            'message' => $message,
            'source' => $source,
            'intent' => $intent['intent_type'],
            'scopes' => $intent['scopes'],
            'confidence' => $intent['confidence'],
            'data_summary' => [
                'total_records' => collect($data)->sum('count')
            ],
            'handover' => false
        ];
    }
}