@props(['model', 'modelName'])

<div class="mt-10 w-full">
    <h2 class="text-xl font-semibold text-dark mb-4">
        {{ $model->comentars->count() }} Komentar
    </h2>

    <div class="comment-list">
        @forelse($model->comentars as $comment)
            <div class="mb-6 pb-6 border-b border-netral-200 last:border-0">
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
                        <div class="font-medium text-dark">
                            {{ $comment->user?->username ?? 'Anonim' }}
                            <span class="text-netral-500 text-sm ml-2">
                                {{ $comment->created_at->format('d M Y H:i') }}
                            </span>
                        </div>
                        <p class="mt-1 text-dark">{{ $comment->content }}</p>
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
                                        <strong class="text-dark">{{ $reply->user?->username ?? 'Anonim' }}</strong>
                                        <span
                                            class="text-netral-500 ml-2">{{ $reply->created_at->format('d M Y H:i') }}</span>
                                    </div>
                                    <p class="text-dark mt-1">{{ $reply->content }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Tombol & Form Balas -->
                <button type="button" class="mt-2 text-sm text-primary hover:underline reply-toggle-btn"
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
                            class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-white text-sm transition-all outline-none"
                            placeholder="Tulis balasan..." required></textarea>
                        <div class="mt-2 flex gap-2">
                            <button type="submit"
                                class="px-3 py-1.5 bg-primary text-white text-sm rounded hover:bg-primary-dark">
                                Kirim
                            </button>
                            <button type="button"
                                class="px-3 py-1.5 text-netral-500 text-sm rounded hover:bg-netral-100 cancel-reply-btn">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-netral-500 italic">Belum ada komentar.</p>
        @endforelse
    </div>

    <!-- Form Komentar Utama -->
    <div class="mt-8 pt-6 border-t border-netral-200">
        <h3 class="font-medium text-dark mb-3">Tambah Komentar</h3>
        <form action="{{ route('commentar.store') }}" method="POST">
            @csrf
            <input type="hidden" name="foundable_type" value="{{ $modelName }}">
            <input type="hidden" name="foundable_id" value="{{ $model->id }}">
            <textarea name="content" rows="3"
                class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none"
                placeholder="Tulis komentar Anda..." required></textarea>
            <button type="submit"
                class="mt-2 px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 transition">
                Kirim Komentar
            </button>
        </form>
    </div>
</div>

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pusher = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
                cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
                encrypted: true
            });

            const channelName = 'comments.{{ addslashes($modelName) }}.{{ $model->id }}';

            const channel = pusher.subscribe(channelName);

            channel.bind('comment.created', function(data) {
                appendComment(data.comment);
            });

            function appendComment(comment) {
                const container = document.querySelector('.comment-list');
                if (!container) return;

                const html = `
            <div class="mb-6 pb-6 border-b border-netral-200">
                <div class="flex gap-3">
                    <img src="${comment.user?.avatar
                        ? '/storage/' + comment.user.avatar
                        : 'https://ui-avatars.com/api/?name=' + comment.user?.username
                    }"
                    class="h-8 w-8 rounded-full">

                    <div class="flex-1">
                        <div class="font-medium">
                            ${comment.user?.username ?? 'Anonim'}
                            <span class="text-sm text-netral-500 ml-2">baru saja</span>
                        </div>
                        <p class="mt-1">${comment.content}</p>
                    </div>
                </div>
            </div>
            `;

                container.insertAdjacentHTML('afterbegin', html);
            }
        });
    </script>
@endpush
