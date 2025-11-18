<?php

namespace App\Livewire;

use App\Services\GeminiConnectService;
use Livewire\Component;

class Chat extends Component
{
    public $messages = [];
    public $prompt = '';

    public $loading = false;

    public function sendMessage(GeminiConnectService $gemini)
    {
        if (trim($this->prompt) === '')
            return;

        // Tambahkan pesan user ke daftar
        $this->messages[] = [
            'sender' => 'user',
            'text' => $this->prompt,
        ];

        $this->loading = true;

        // Kirim ke Gemini
        $reply = $gemini->generateContent($this->prompt);

        $this->loading = false;

        // Tambahkan balasan AI
        $this->messages[] = [
            'sender' => 'bot',
            'text' => $reply,
        ];

        // Reset input
        $this->prompt = '';
    }

    public function render()
    {
        return view('livewire.chat')->layout('layouts.index')->title('Profile | InfoHilang');
    }
}
