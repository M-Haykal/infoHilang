<div>
    <div class="max-w-md mx-auto mt-20 p-4 border rounded-lg shadow">
        <h2 class="text-lg font-bold mb-3 text-center">💬 Chat dengan Gemini AI</h2>

        <div class="h-80 overflow-y-auto border p-3 mb-3 rounded bg-gray-50">
            @forelse ($messages as $msg)
                @if ($msg['sender'] === 'user')
                    <div class="text-right mb-2">
                        <span class="inline-block bg-blue-500 text-white px-3 py-1 rounded-lg">
                            {{ $msg['text'] }}
                        </span>
                    </div>
                @else
                    <div class="text-left mb-2">
                        <span class="inline-block bg-gray-300 px-3 py-1 rounded-lg">
                            🤖 {{ $msg['text'] }}
                        </span>
                    </div>
                @endif
            @empty
                <p class="text-gray-500 text-center">Mulai percakapan dengan Gemini AI 👇</p>
            @endforelse

            @if ($loading)
                <p class="text-gray-400 text-sm text-center">Mengetik...</p>
            @endif
        </div>

        <form wire:submit.prevent="sendMessage" class="flex space-x-2">
            <input type="text" wire:model="prompt" placeholder="Ketik pesan..."
                class="flex-1 border rounded px-3 py-2 focus:outline-none focus:ring">
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 disabled:opacity-50"
                @disabled($loading)>
                Kirim
            </button>
        </form>
    </div>

</div>
