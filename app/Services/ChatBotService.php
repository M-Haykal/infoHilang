<?php

namespace App\Services;

use App\Models\BarangHilang;
use App\Models\HewanHilang;
use App\Models\OrangHilang;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;

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

    protected $greetings = ['Halo! 👋', 'Hai! 😊', 'Selamat datang! 🙏', 'Halo kak! 👋'];
    protected $closings = ['Semoga membantu! 🙏', 'Ada lagi yang bisa saya bantu? 😊', 'Silakan tanya lagi jika perlu! 👋', 'Semoga yang hilang cepat ketemu! 🤲'];

    public function __construct(GeminiConnectService $geminiService)
    {
        $this->geminiService = $geminiService;
        $this->loadAnimals();
    }

    protected function loadAnimals(): void
    {
        $path = public_path('json/animals.json');
        if (file_exists($path)) {
            $this->animals = json_decode(file_get_contents($path), true) ?? [];
        }
    }

    // ============================================================
    //  ENTRY POINT
    // ============================================================
    public function processMessage(string $message, ?int $userId = null, ?string $sessionId = null): array
    {
        try {
            $message = trim($message);
            Log::info('[CHATBOT] Start', ['message' => $message]);

            $this->saveMessage($userId, $sessionId, 'user', $message);

            // Interpretasi menggunakan AI + fallback if-else
            $intent = $this->interpretMessage($message);
            Log::info('[CHATBOT] Intent', $intent);

            // Jika intent tidak valid atau meminta handover, langsung handover
            if (!$intent['is_valid'] || $intent['intent'] === 'handover') {
                return $this->handoverToAdmin($message, $userId, 'Invalid or handover intent');
            }

            $contextData = $this->fetchDatabaseData($intent);
            $totalRecords = collect($contextData)->sum('count');
            Log::info('[CHATBOT] Data fetched', ['total' => $totalRecords]);

            $response = $this->generateResponse($message, $contextData, $intent);

            $this->saveMessage($userId, $sessionId, 'bot', $response, [
                'intent' => $intent,
                'total_records' => $totalRecords
            ]);

            return $this->successResponse($response, 'ai', $intent, $contextData);

        } catch (\Exception $e) {
            Log::error('[CHATBOT] Error', ['error' => $e->getMessage()]);
            $this->markAsHandover($userId, $sessionId);
            return $this->handoverToAdmin($message, $userId, 'Error: ' . $e->getMessage());
        }
    }

    // ============================================================
    //  INTERPRETASI: AI + FALLBACK IF-ELSE (PERBAIKAN)
    // ============================================================
    protected function interpretMessage(string $message): array
    {
        // Coba dengan Gemini terlebih dahulu
        try {
            $result = $this->interpretWithGemini($message);
            // Jika Gemini memberikan intent selain handover dan valid, gunakan
            if ($this->isValidIntent($result) && $result['intent'] !== 'handover') {
                $result['is_valid'] = true;
                return $result;
            }
            // Jika Gemini mengembalikan handover, kita lanjut ke fallback
            Log::info('Gemini mengembalikan handover, lanjut ke fallback');
        } catch (\Exception $e) {
            Log::warning('Gemini interpretasi gagal, fallback ke regex', ['error' => $e->getMessage()]);
        }

        // Fallback ke logika if-else (regex)
        return $this->fallbackIntentDetection($message);
    }

    protected function interpretWithGemini(string $message): array
    {
        $prompt = "Anda adalah asisten yang memahami maksud pertanyaan user tentang laporan kehilangan (orang, hewan, barang).
Berikut adalah pertanyaan user: \"$message\"

Tentukan:
- intent: apakah user ingin mencari data (search), menghitung jumlah (count), melihat statistik (statistics), atau pertanyaan lain yang membutuhkan admin (handover). Pilih salah satu: search, count, statistics, handover.
- scopes: kategori yang relevan, pilih dari ['barang_hilang','hewan_hilang','orang_hilang'].
- keyword: kata kunci yang dicari (nama barang, hewan, orang) jika ada, else null.
- location: lokasi yang disebutkan jika ada, else null.
- confidence: tingkat keyakinan 0-1.

Output HANYA dalam format JSON:
{\"intent\":\"...\", \"scopes\":[\"...\"], \"keyword\":\"...\", \"location\":\"...\", \"confidence\":0.0}";

        $response = $this->geminiService->generateContent($prompt);
        $cleanJson = preg_replace('/^```json\s*|\s*```$/m', '', trim($response));
        $data = json_decode($cleanJson, true);

        if (!$data || !isset($data['intent'])) {
            throw new \Exception('Invalid AI response');
        }

        // Validasi & normalisasi
        if (!in_array($data['intent'], ['search','count','statistics','handover'])) {
            $data['intent'] = 'handover';
        }
        if (!isset($data['scopes']) || !is_array($data['scopes'])) {
            $data['scopes'] = array_keys($this->allowedScopes);
        }
        $data['scopes'] = array_intersect($data['scopes'], array_keys($this->allowedScopes));
        if (empty($data['scopes'])) {
            $data['scopes'] = array_keys($this->allowedScopes);
        }
        $data['keyword'] = $data['keyword'] ?? null;
        $data['location'] = $data['location'] ?? null;
        $data['confidence'] = $data['confidence'] ?? 0.5;

        return $data;
    }

    protected function isValidIntent(array $intent): bool
    {
        return isset($intent['intent']) && in_array($intent['intent'], ['search','count','statistics','handover']);
    }

    // ============================================================
    //  FALLBACK DENGAN IF-ELSE (REGEX) - PERBAIKAN
    // ============================================================
    protected function fallbackIntentDetection(string $message): array
    {
        $scopes = [];
        $intentType = null;
        $keyword = null;
        $location = null;

        // --- Kategori (if-else) ---
        if (preg_match('/\b(barang|laptop|hp|handphone|dompet|tas|sepeda|motor|mobil|kunci|jam)\b/i', $message)) {
            $scopes[] = 'barang_hilang';
        }
        if (preg_match('/\b(hewan|binatang|peliharaan|kucing|anjing|kelinci|hamster|burung|ikan)\b/i', $message) || $this->containsAnimal($message)) {
            $scopes[] = 'hewan_hilang';
        }
        if (preg_match('/\b(orang|manusia|anak|bayi|bapak|ibu|nenek|kakek)\b/i', $message)) {
            $scopes[] = 'orang_hilang';
        }

        // --- Intent (if-else) ---
        if (preg_match('/\b(cari|temukan|siapa|ada|lihat|dimana|mencari)\b/i', $message)) {
            $intentType = 'search';
            $keyword = $this->extractKeyword($message);
        } elseif (preg_match('/\b(berapa|jumlah|total|count|banyaknya|ada berapa)\b/i', $message)) {
            $intentType = 'count';
        } elseif (preg_match('/\b(statistik|ringkasan|rekap|summary|data)\b/i', $message)) {
            $intentType = 'statistics';
        }

        // --- Lokasi ---
        if (preg_match('/\b(di|lokasi|area|kota|daerah|tempat)\s+([a-zA-Z\s]{3,30})\b/i', $message, $m)) {
            $location = trim($m[2]);
        }

        // Default scope jika tidak terdeteksi
        if (empty($scopes) && $intentType) {
            $scopes = array_keys($this->allowedScopes);
        }

        return [
            'intent' => $intentType ?? 'handover',
            'scopes' => array_unique($scopes),
            'keyword' => $keyword,
            'location' => $location,
            'confidence' => $this->calculateConfidence($scopes, $intentType, $keyword),
            'is_valid' => !empty($scopes) && $intentType
        ];
    }

    // ============================================================
    //  EXTRACT KEYWORD - PERBAIKAN (tambah "ada kah")
    // ============================================================
    protected function extractKeyword(string $message): ?string
    {
        // Pola "bernama X", "nama X", "dengan nama X"
        if (preg_match('/\b(bernama|nama|dengan nama)\s+([a-zA-Z0-9\s\-]{2,30})/i', $message, $m)) {
            return trim($m[2]);
        }
        // Pola "cari X" atau "cari barang X"
        if (preg_match('/cari\s+(?:barang|hewan|orang)?\s+([a-zA-Z0-9\s\-]{2,30}?)(?:\s+di|\s+yang|$)/i', $message, $m)) {
            return trim($m[1]);
        }
        // Pola "ada X", "apakah ada X", "adakah X", "ada kah X"
        if (preg_match('/\b(ada|apakah ada|adakah|ada kah)\s+([a-zA-Z0-9\s\-]{2,30})(?:\s+di|\s+yang|$)/i', $message, $m)) {
            return trim($m[2]);
        }
        return null;
    }

    protected function containsAnimal(string $message): bool
    {
        foreach ($this->animals as $animal) {
            if (str_contains($message, strtolower($animal))) return true;
        }
        return false;
    }

    protected function calculateConfidence(array $scopes, ?string $intentType, ?string $keyword): float
    {
        $score = 0;
        if (!empty($scopes)) $score += 0.4;
        if ($intentType) $score += 0.3;
        if ($keyword) $score += 0.2;
        return min($score, 1.0);
    }

    // ============================================================
    //  FETCH DATA DARI DATABASE
    // ============================================================
    protected function fetchDatabaseData(array $intent): array
    {
        $data = [];
        $isCount = ($intent['intent'] === 'count');

        foreach ($intent['scopes'] as $scopeKey) {
            try {
                $config = $this->allowedScopes[$scopeKey];
                $model = $config['model'];
                $query = $model::query();

                if ($intent['keyword']) {
                    $field = $this->getSearchField($scopeKey);
                    $query->where($field, 'like', "%{$intent['keyword']}%");
                }
                if ($intent['location']) {
                    $query->where('lokasi_terakhir_dilihat', 'like', "%{$intent['location']}%");
                }

                if ($isCount) {
                    // Total semua data (tanpa limit)
                    $data[$scopeKey] = [
                        'count' => $query->count(),
                        'records' => []
                    ];
                } else {
                    // Ambil 10 data terakhir
                    $records = $query->latest()->limit(10)->get();
                    $data[$scopeKey] = [
                        'count' => $records->count(),
                        'records' => $records->toArray()
                    ];
                }
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

    // ============================================================
    //  GENERATE RESPONSE (AI + TEMPLATE FALLBACK)
    // ============================================================
    protected function generateResponse(string $message, array $contextData, array $intent): string
    {
        $total = collect($contextData)->sum('count');
        $greeting = $this->getRandomGreeting();

        if ($total === 0) {
            return $this->generateNotFoundResponse($intent, $greeting);
        }

        // Coba dengan AI
        try {
            $prompt = $this->buildNaturalPrompt($message, $contextData, $intent, $greeting);
            $aiResponse = $this->geminiService->generateContent($prompt);
            if (!empty($aiResponse) && strlen($aiResponse) > 10) {
                return $aiResponse;
            }
            throw new \Exception('AI response empty');
        } catch (\Exception $e) {
            Log::warning('AI response gagal, pakai template', ['error' => $e->getMessage()]);
            return $this->generateNaturalTemplateResponse($contextData, $intent, $greeting);
        }
    }

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

    protected function generateNaturalTemplateResponse(array $contextData, array $intent, string $greeting): string
    {
        $total = collect($contextData)->sum('count');
        $parts = [$greeting];
        if ($intent['intent'] === 'count') {
            $parts[] = $this->formatCountResponse($contextData, $total);
        } else {
            $parts[] = $this->formatSearchResponse($contextData, $total, $intent);
        }
        $parts[] = $this->getRandomClosing();
        return implode("\n\n", $parts);
    }

    protected function formatCountResponse(array $contextData, int $total): string
    {
        if ($total === 0) return "Saat ini belum ada laporan kehilangan di sistem kami 📋";
        $lines = ["Saat ini ada **{$total} laporan kehilangan** di sistem kami 📊"];
        foreach ($contextData as $scope => $info) {
            if ($info['count'] === 0) continue;
            $name = str_replace('_hilang', '', $scope);
            $emoji = ['barang' => '📦', 'hewan' => '🐾', 'orang' => '👤'][$name] ?? '📋';
            $label = ['barang' => 'Barang', 'hewan' => 'Hewan', 'orang' => 'Orang'][$name] ?? $name;
            $model = $this->allowedScopes[$scope]['model'];
            $hilang = $model::where('status', 'like', '%Hilang%')->count();
            $ditemukan = $model::where('status', 'like', '%Ditemukan%')->count();
            $lines[] = "{$emoji} **{$label}**: {$info['count']} total ({$hilang} hilang, {$ditemukan} ditemukan)";
        }
        return implode("\n", $lines);
    }

    protected function formatSearchResponse(array $contextData, int $total, array $intent): string
    {
        $keyword = $intent['keyword'] ?? null;
        $location = $intent['location'] ?? null;
        $header = "Saya menemukan **{$total} laporan**";
        if ($keyword) $header .= " terkait '{$keyword}'";
        if ($location) $header .= " di {$location}";
        $header .= " 🔍";
        $lines = [$header];
        foreach ($contextData as $scope => $info) {
            if ($info['count'] === 0) continue;
            $name = str_replace('_hilang', '', $scope);
            $emoji = ['barang' => '📦', 'hewan' => '🐾', 'orang' => '👤'][$name] ?? '📋';
            $label = ['barang' => 'Barang', 'hewan' => 'Hewan', 'orang' => 'Orang'][$name] ?? $name;
            $lines[] = "\n{$emoji} **{$label}** ({$info['count']} data):";
            foreach (array_slice($info['records'], 0, 3) as $i => $r) {
                $itemName = $r['nama_barang'] ?? $r['nama_hewan'] ?? $r['nama_orang'] ?? 'Tidak bernama';
                $itemLoc = $r['lokasi_terakhir_dilihat'] ?? 'Lokasi tidak diketahui';
                $itemStatus = $r['status'] ?? 'Status tidak diketahui';
                $statusEmoji = str_contains(strtolower($itemStatus), 'hilang') ? '🆘' : '✅';
                $lines[] = ($i+1) . ". **{$itemName}**";
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

    protected function buildNaturalPrompt(string $message, array $contextData, array $intent, string $greeting): string
    {
        $contextText = "";
        foreach ($contextData as $scope => $info) {
            if ($info['count'] === 0) continue;
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

    // ============================================================
    //  HELPERS
    // ============================================================
    protected function getRandomGreeting(): string
    {
        return $this->greetings[array_rand($this->greetings)];
    }

    protected function getRandomClosing(): string
    {
        return $this->closings[array_rand($this->closings)];
    }

    // ============================================================
    //  DATABASE SAVE, HANDOVER, ADMIN METHODS
    // ============================================================
    protected function saveMessage(?int $userId, ?string $sessionId, string $sender, string $message, array $metadata = []): ChatMessage
    {
        $chatMessage = ChatMessage::create([
            'user_id' => $userId,
            'session_id' => $sessionId ?? Str::uuid(),
            'sender' => $sender,
            'message' => $message,
            'metadata' => !empty($metadata) ? $metadata : null
        ]);
        if ($sender === 'user') {
            \App\Events\ChatMessageReceived::dispatch(
                'admin.chat',
                [
                    'sessionId' => $chatMessage->user_id ?? $chatMessage->session_id,
                    'message' => $message
                ],
                'system'
            );
        }
        return $chatMessage;
    }

    protected function markAsHandover(?int $userId, ?string $sessionId): void
    {
        ChatMessage::where(function ($q) use ($userId, $sessionId) {
            if ($userId) $q->where('user_id', $userId);
            if ($sessionId) $q->orWhere('session_id', $sessionId);
        })->latest()->limit(1)->update(['is_handover' => true]);
    }

    protected function handoverToAdmin(string $message, ?int $userId, string $reason, ?string $sessionId = null): array
    {
        Log::info('Handover', ['reason' => $reason]);
        $this->markAsHandover($userId, $sessionId);
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

    protected function successResponse(string $message, string $source, array $intent, array $data): array
    {
        return [
            'success' => true,
            'message' => $message,
            'source' => $source,
            'intent' => $intent['intent'],
            'scopes' => $intent['scopes'],
            'confidence' => $intent['confidence'] ?? 0,
            'data_summary' => ['total_records' => collect($data)->sum('count')],
            'handover' => false
        ];
    }

    // ============================================================
    //  ADMIN METHODS
    // ============================================================
    public function getActiveSessions(): array
    {
        $sessions = ChatMessage::with('user')
            ->where('is_handled', false)
            ->latest()
            ->get()
            ->groupBy(function ($item) {
                return $item->user_id ?? $item->session_id;
            })
            ->map(function ($messages) {
                $last = $messages->first();
                return [
                    'id' => $last->user_id ?? $last->session_id,
                    'user' => $last->user,
                    'name' => $last->user ? $last->user->name : 'Guest User',
                    'email' => $last->user ? $last->user->email : 'Tamu',
                    'is_guest' => $last->user_id === null,
                    'last_message' => $last->message,
                    'last_time' => $last->created_at->diffForHumans(),
                    'is_handover' => $last->is_handover,
                    'has_awaiting_reply' => $last->is_handover,
                    'total_messages' => $messages->count()
                ];
            })
            ->values()
            ->toArray();
        return $sessions;
    }

    public function getUserMessages($identifier): array
    {
        $isUserId = is_numeric($identifier);
        return ChatMessage::where(function ($q) use ($identifier, $isUserId) {
            if ($isUserId) {
                $q->where('user_id', $identifier);
            } else {
                $q->where('session_id', $identifier);
            }
        })
        ->oldest()
        ->get()
        ->map(function($msg) {
            return [
                'sender' => $msg->sender,
                'message' => $msg->message,
                'created_at' => $msg->created_at,
                'time' => $msg->created_at->diffForHumans(),
                'is_user' => $msg->sender === 'user',
                'is_admin' => $msg->sender === 'admin',
                'is_bot' => $msg->sender === 'bot'
            ];
        })
        ->toArray();
    }

    public function sendAdminReply($identifier, string $message, int $adminId): array
    {
        $isUserId = is_numeric($identifier);
        $chatMessage = $this->saveMessage(
            $isUserId ? $identifier : null,
            $isUserId ? null : $identifier,
            'admin',
            $message,
            ['admin_id' => $adminId]
        );
        \App\Events\ChatMessageReceived::dispatch(
            $chatMessage->user_id ?? $chatMessage->session_id,
            [
                'message' => $message,
                'sender' => 'admin',
                'time' => $chatMessage->created_at->diffForHumans()
            ],
            'admin'
        );
        return [
            'success' => true,
            'message' => 'Balasan terkirim'
        ];
    }

    public function markSessionHandled($identifier): void
    {
        $isUserId = is_numeric($identifier);
        ChatMessage::where(function ($q) use ($identifier, $isUserId) {
            if ($isUserId) {
                $q->where('user_id', $identifier);
            } else {
                $q->where('session_id', $identifier);
            }
        })->update([
            'is_handled' => true,
            'handled_at' => Carbon::now(),
            'handled_by' => auth()->id()
        ]);
    }
}