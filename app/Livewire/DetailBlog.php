<?php

namespace App\Livewire;

use App\Models\Blog;
use Livewire\Component;

class DetailBlog extends Component
{
    public $blog;

    public function mount($slug)
    {
        // Mencari artikel berdasarkan slug, kalau tidak ada lempar 404
        $this->blog = Blog::with('user')
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function render()
    {
        // ambil 2 artikel terkait (terbaru selain yang lagi dibuka)
        $relatedBlogs = Blog::where('id', '!=', $this->blog->id)
            ->latest()
            ->take(2)
            ->get();

        return view('livewire.detail-blog', [
            'relatedBlogs' => $relatedBlogs
        ])
        ->layout('layouts.index')
        ->title($this->blog->title . ' | InfoHilang');
    }
}
