@extends('dashboard.layouts.index')

@section('title', 'Detail Laporan Orang Hilang | InfoHilang')

@section('content')
    {{-- ... konten detail laporan ... --}}

    <!-- Bagian Komentar -->
    <div class="mt-10 max-w-3xl mx-auto">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">
            {{ $orangHilang->comentars->count() }} Komentar
        </h2>

        @forelse($orangHilang->comentars as $comment)
            <div class="mb-6 pb-6 border-b border-gray-200 last:border-0">
                <!-- Komentar Utama -->
                <div class="flex gap-3">
                    <div class="flex-shrink-0">
                        <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->username) . '&background=1E88E5&color=fff' }}"
                            class="h-8 w-8 rounded-full border border-white" alt="Avatar">
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

                <!-- Balasan (jika ada) -->
                @if ($comment->replies->count())
                    <div class="mt-4 pl-8 space-y-3">
                        @foreach ($comment->replies as $reply)
                            <div class="flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="bg-gray-100 rounded-full w-8 h-8 flex items-center justify-center text-xs">
                                        <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->username) . '&background=1E88E5&color=fff' }}"
                                            class="h-8 w-8 rounded-full border border-white" alt="Avatar">
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm">
                                        <strong class="text-gray-800">{{ $reply->user->username }}</strong>
                                        <span
                                            class="text-gray-500 ml-2">{{ $reply->created_at->format('d M Y H:i') }}</span>
                                    </div>
                                    <p class="text-gray-700 mt-1">{{ $reply->content }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                <button type="button" class="mt-2 text-sm text-primary hover:underline reply-toggle-btn"
                    data-comment-id="{{ $comment->id }}">
                    Balas
                </button>

                <div class="mt-3 reply-form hidden" id="reply-form-{{ $comment->id }}">
                    <form action="{{ route('commentar.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="foundable_type" value="App\Models\OrangHilang">
                        <input type="hidden" name="foundable_id" value="{{ $orangHilang->id }}">
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        <textarea name="content" rows="2"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary"
                            placeholder="Tulis balasan..." required></textarea>
                        <div class="mt-2 flex gap-2">
                            <button type="submit"
                                class="px-3 py-1.5 bg-primary text-white text-sm rounded hover:bg-primary/90">
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
        <!-- Form Tambah Komentar -->
        <div class="mt-8 pt-6 border-t border-gray-200">
            <h3 class="font-medium text-gray-800 mb-3">Tambah Komentar</h3>
            <form action="{{ route('commentar.store') }}" method="POST">
                @csrf
                <input type="hidden" name="foundable_type" value="App\Models\OrangHilang">
                <input type="hidden" name="foundable_id" value="{{ $orangHilang->id }}">
                <textarea name="content" rows="3"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-primary"
                    placeholder="Tulis komentar Anda..." required></textarea>
                <button type="submit"
                    class="mt-2 px-4 py-2 bg-success text-white rounded-lg hover:bg-success/90 transition">
                    Kirim Komentar
                </button>
            </form>
        </div>
    </div>

@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.reply-toggle-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const commentId = this.dataset.commentId;
                    const form = document.getElementById(`reply-form-${commentId}`);
                    form.classList.toggle('hidden');

                    if (!form.classList.contains('hidden')) {
                        form.querySelector('textarea').focus();
                    }
                });
            });

            document.querySelectorAll('.cancel-reply-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('.reply-form');
                    form.classList.add('hidden');
                    form.querySelector('textarea').value = ''; 
                });
            });
        });
    </script>
@endpush
