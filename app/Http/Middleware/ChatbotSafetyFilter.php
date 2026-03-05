<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChatbotSafetyFilter
{
    protected $blockedKeywords = [
        'sql injection',
        'drop table',
        'delete from',
        'truncate',
        'hack',
        'exploit',
        'vulnerability',
        'breach',
        'data pribadi',
        'nomor hp',
        'email orang',
        'password orang'
    ];

    protected $maxRequestsPerMinute = 20;

    /**
     * Pre-filter sebelum masuk ke AI
     */
    public function preFilter(string $message): array
    {
        // 1. Sanitize input
        $clean = $this->sanitize($message);

        // 2. Check blocked keywords
        foreach ($this->blockedKeywords as $blocked) {
            if (str_contains(strtolower($clean), $blocked)) {
                return [
                    'allowed' => false,
                    'reason' => 'Security: blocked keyword detected',
                    'action' => 'block'
                ];
            }
        }

        // 3. Check length
        if (strlen($clean) > 1000) {
            return [
                'allowed' => false,
                'reason' => 'Input too long',
                'action' => 'block'
            ];
        }

        return [
            'allowed' => true,
            'message' => $clean
        ];
    }

    /**
     * Post-filter setelah AI generate response
     */
    public function postFilter(string $aiResponse, array $contextData): array
    {
        // 1. Cek jika AI menyebut data yang tidak ada di context (hallucination)
        $mentionedData = $this->extractMentionedData($aiResponse);
        $allowedData = $this->flattenContextData($contextData);

        foreach ($mentionedData as $mention) {
            if (!in_array($mention, $allowedData)) {
                // AI hallucinating!
                return [
                    'valid' => false,
                    'reason' => 'AI hallucination detected',
                    'fallback' => 'Maaf, saya tidak bisa memverifikasi informasi tersebut. Hubungi admin untuk bantuan.'
                ];
            }
        }

        // 2. Cek panjang response
        if (strlen($aiResponse) > 500) {
            return [
                'valid' => false,
                'reason' => 'Response too long',
                'fallback' => substr($aiResponse, 0, 500) . '...'
            ];
        }

        return ['valid' => true, 'response' => $aiResponse];
    }

    protected function sanitize(string $input): string
    {
        // Remove HTML tags
        $clean = strip_tags($input);
        // Remove special chars tapi pertahankan huruf, angka, spasi, dan tanda baca dasar
        $clean = preg_replace('/[^\w\s\-.,!?()]/u', '', $clean);
        return trim($clean);
    }

    protected function extractMentionedData(string $response): array
    {
        // Extract nama-nama yang disebut AI
        preg_match_all('/\b[A-Z][a-zA-Z\s]{2,30}\b/u', $response, $matches);
        return array_unique($matches[0] ?? []);
    }

    protected function flattenContextData(array $contextData): array
    {
        $names = [];
        foreach ($contextData as $scope => $info) {
            foreach ($info['records'] ?? [] as $record) {
                $nameField = $record['nama_barang'] ?? $record['nama_hewan'] ?? $record['nama_orang'] ?? null;
                if ($nameField) {
                    $names[] = $nameField;
                    // Tambahkan partial names juga
                    $words = explode(' ', $nameField);
                    foreach ($words as $word) {
                        if (strlen($word) > 3) {
                            $names[] = $word;
                        }
                    }
                }
            }
        }
        return array_unique($names);
    }
}
