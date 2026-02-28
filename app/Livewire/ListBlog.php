<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Blog;
use Illuminate\Http\Request;

class ListBlog extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';

    public function render()
    {
        // Mengambil artikel terbaru, 6 per halaman
        $blogs = Blog::with('user')
            ->latest()
            ->paginate(6);

        return view('livewire.list-blog', ['blogs' => $blogs])
        ->layout('layouts.index')
        ->title('Daftar Artikel | InfoHilang');
    }

    public function show($slug)
    {
        // Mencari artikel berdasarkan slug
        $blog = Blog::with('user')
            ->where('slug', $slug)
            ->firstOrFail();

        // Mengambil artikel terkait untuk bagian bawah halaman
        $relatedBlogs = Blog::where('id', '!=', $blog->id)
            ->latest()
            ->take(2)
            ->get();

        return view('livewire.detail-blog', compact('blog', 'relatedBlogs'))
        ->layout('layouts.index')
        ->title('Daftar Artikel | InfoHilang');
    }
}
