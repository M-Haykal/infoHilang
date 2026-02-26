<div class="max-w-7xl mx-auto px-4 py-20 sm:px-6 lg:px-8">
    {{-- Header Section --}}
    <div class="text-center mb-16" data-aos="fade-up">
        <h2 class="text-primary font-bold uppercase tracking-widest text-sm mb-3">Edukasi & Tips</h2>
        <h1 class="text-4xl md:text-5xl font-black text-dark mb-6">Wawasan Terbaru <br class="hidden md:block"> dari
            Info<span class="text-primary">Hilang</span></h1>
        <p class="text-netral-500 max-w-2xl mx-auto text-lg">Pelajari tips keamanan, cara efektif mencari barang
            hilang, dan edukasi seputar komunitas kami.</p>
    </div>

    <!-- PageHeading -->
    <div class="text-center mb-10">
        <h2 class="text-3xl md:text-4xl font-extrabold text-dark">Daftar Hilang <span class="text-primary">&amp;</span> Ditemukan</h2>
        <div class="w-20 h-1.5 bg-accent mx-auto rounded-full mt-4"></div>
    </div>

    {{-- Artikel Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($blogs as $blog)
        <article class="group bg-white rounded-3xl border border-netral-100 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-500 flex flex-col" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
            {{-- Image Thumbnail --}}
            <div class="relative aspect-[16/10] overflow-hidden">
                <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute top-4 left-4">
                    <span class="bg-white/90 backdrop-blur px-3 py-1 rounded-full text-[10px] font-bold text-primary shadow-sm uppercase">Tips</span>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-6 flex flex-col flex-1">
                <div class="flex items-center gap-2 mb-4 text-[10px] font-bold text-netral-400 uppercase tracking-widest">
                    <span>{{ $blog->user->fullname }}</span>
                    <span class="w-1 h-1 bg-netral-200 rounded-full"></span>
                    <span>{{ $blog->created_at->diffForHumans() }}</span>
                </div>

                <h3 class="text-xl font-bold text-dark mb-3 line-clamp-2 group-hover:text-primary transition-colors">
                    {{ $blog->title }}
                </h3>

                <p class="text-netral-500 text-sm line-clamp-3 mb-6 flex-1">
                    {{ Str::limit(strip_tags($blog->content), 120) }}
                </p>

                {{-- Tombol Detail --}}
                <a href="{{ route('landing.artikel.show', $blog->slug) }}" class="inline-flex items-center justify-center gap-2 w-full py-3.5 bg-netral-50 text-dark font-bold text-sm rounded-2xl hover:bg-primary hover:text-white transition-all duration-300 group/btn">
                    Baca Selengkapnya
                    <i class="fa-solid fa-arrow-right transition-transform group-hover/btn:translate-x-1"></i>
                </a>
            </div>
        </article>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-16">
        {{ $blogs->links() }}
    </div>
</div>
