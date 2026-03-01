<div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
    {{-- Breadcrumb --}}
    <nav class="flex mb-6 text-sm text-netral-500" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2">
            <li><a href="/" class="hover:text-primary transition">Beranda</a></li>
            <li><i class="fa-solid fa-chevron-right text-[10px] opacity-50"></i></li>
            <li><a href="{{ route('list-blog') }}" class="hover:text-primary transition">Artikel</a></li>
            <li><i class="fa-solid fa-chevron-right text-[10px] opacity-50"></i></li>
            <li class="font-semibold text-dark italic truncate max-w-[150px] sm:max-w-[300px] md:max-w-[500px]" title="{{ $blog->title }}">{{ $blog->title }}</li>
        </ol>
    </nav>

    <div class="w-full">

        {{-- Konten Utama Artikel --}}
        <div class="bg-white rounded-2xl shadow-sm border border-netral-100 overflow-hidden p-6 sm:p-8">
            {{-- resources/views/components/article-detail.blade.php --}}
            <x-article-detail :blog="$blog" />
        </div>

        {{-- Section Artikel Terkait --}}
        @if($relatedBlogs->count() > 0)
            <div class="mt-12">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-dark">Artikel Terkait</h3>
                    <a href="{{ route('list-blog') }}" class="text-sm font-bold text-primary hover:underline">Lihat Semua</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($relatedBlogs as $related)
                        <a href="{{ route('detail-blog', $related->slug) }}" class="group flex gap-4 bg-white p-4 rounded-2xl border border-netral-100 hover:shadow-md transition-all">
                            {{-- Thumbnail Kecil --}}
                            <div class="w-24 h-24 rounded-lg overflow-hidden flex-shrink-0">
                                <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>

                            {{-- Info Artikel --}}
                            <div class="flex flex-col justify-center">
                                <p class="text-[10px] font-bold text-primary uppercase mb-1">
                                    {{ $related->created_at->translatedFormat('d M Y') }}
                                </p>
                                <h4 class="font-bold text-dark group-hover:text-primary transition-colors line-clamp-2 mb-1">
                                    {{ $related->title }}
                                </h4>
                                <p class="text-netral-500 text-sm line-clamp-2 flex-1">
                                    {{ Str::limit(strip_tags($blog->content), 100) }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
