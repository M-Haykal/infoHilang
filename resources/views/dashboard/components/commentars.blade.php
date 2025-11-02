@props(['model', 'modelName'])

<div class="mt-10 max-w-3xl">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">
        {{ $model->comentars->count() }} Komentar
    </h2>

    @forelse($model->comentars as $comment)
        <div class="mb-6 pb-6 border-b border-gray-200 last:border-0">
            <!-- Komentar Utama -->
            <div class="flex gap-3">
                <div class="flex-shrink-0">
                    @if ($comment->user && $comment->user->avatar)
                        <img src="{{ asset('storage/' . $comment->user->avatar) }}"
                            class="h-8 w-8 rounded-full border border-white" alt="Avatar">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user?->username ?? 'Anonim') }}&background=1E88E5&color=fff"
                            class="h-8 w-8 rounded-full border border-white" alt="Avatar">
                    @endif
                </div>
                <div class="flex-1">
                    <div class="font-medium text-gray-800">
                        {{ $comment->user?->username ?? 'Anonim' }}
                        <span class="text-gray-500 text-sm ml-2">
                            {{ $comment->created_at->format('d M Y H:i') }}
                        </span>
                    </div>
                    <p class="mt-1 text-gray-700">{{ $comment->content }}</p>
                </div>
            </div>

            <!-- Balasan -->
            @if ($comment->replies->count())
                <div class="mt-4 pl-8 space-y-3">
                    @foreach ($comment->replies as $reply)
                        <div class="flex gap-3">
                            <div class="flex-shrink-0">
                                @if ($reply->user && $reply->user->avatar)
                                    <img src="{{ asset('storage/' . $reply->user->avatar) }}"
                                        class="h-8 w-8 rounded-full border border-white" alt="Avatar">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($reply->user?->username ?? 'Anonim') }}&background=1E88E5&color=fff"
                                        class="h-8 w-8 rounded-full border border-white" alt="Avatar">
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="text-sm">
                                    <strong class="text-gray-800">{{ $reply->user?->username ?? 'Anonim' }}</strong>
                                    <span
                                        class="text-gray-500 ml-2">{{ $reply->created_at->format('d M Y H:i') }}</span>
                                </div>
                                <p class="text-gray-700 mt-1">{{ $reply->content }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Tombol & Form Balas -->
            <button type="button" class="mt-2 text-sm text-blue-600 hover:underline reply-toggle-btn"
                data-comment-id="{{ $comment->id }}">
                Balas
            </button>

            <div class="mt-3 reply-form hidden" id="reply-form-{{ $comment->id }}">
                <form action="{{ route('commentar.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="foundable_type" value="{{ $modelName }}">
                    <input type="hidden" name="foundable_id" value="{{ $model->id }}">
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                    <textarea name="content" rows="2"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500"
                        placeholder="Tulis balasan..." required></textarea>
                    <div class="mt-2 flex gap-2">
                        <button type="submit"
                            class="px-3 py-1.5 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                            Kirim
                        </button>
                        <button type="button"
                            class="px-3 py-1.5 text-gray-600 text-sm rounded hover:bg-gray-100 cancel-reply-btn">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @empty
        <p class="text-gray-500 italic">Belum ada komentar.</p>
    @endforelse

    <!-- Form Komentar Utama -->
    <div class="mt-8 pt-6 border-t border-gray-200">
        <h3 class="font-medium text-gray-800 mb-3">Tambah Komentar</h3>
        <form action="{{ route('commentar.store') }}" method="POST">
            @csrf
            <input type="hidden" name="foundable_type" value="{{ $modelName }}">
            <input type="hidden" name="foundable_id" value="{{ $model->id }}">
            <textarea name="content" rows="3"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
                placeholder="Tulis komentar Anda..." required></textarea>
            <button type="submit"
                class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Kirim Komentar
            </button>
        </form>
    </div>
</div>

@push('script')
    <script>
       
    </script>
@endpush
