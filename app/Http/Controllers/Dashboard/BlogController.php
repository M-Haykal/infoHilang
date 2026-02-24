<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $blogs = Blog::with('user')->latest()->get();

        return view('dashboard.pages.blogs.index', compact('blogs'));
    }

    public function show($slug)
    {
        $blog = Blog::with('user')->where('slug', $slug)->firstOrFail();

        return view('dashboard.pages.blogs.show', compact('blog'));
    }

    public function create()
    {

        return view('dashboard.pages.blogs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_artikel' => 'required|max:255',
            'isi_artikel' => 'required',
            'foto' => 'image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('foto')) {
            $imagePath = $request->file('foto')->store('blogs', 'public');
        }

        Blog::create([
            'title'   => $request->judul_artikel,
            'slug'    => Str::slug($request->judul_artikel) . '-' . Str::random(5),
            'content' => $request->isi_artikel,
            'image'   => $imagePath,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('artikel')->with('success', 'Artikel berhasil diterbitkan!');
    }

    public function destroy($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();

        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();

        return redirect()->route('artikel')->with('success', 'Artikel berhasil dihapus selamanya!');
    }
}
