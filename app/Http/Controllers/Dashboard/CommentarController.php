<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CommentarService;
use App\Models\Comentar;

class CommentarController extends Controller
{
    protected $commentarService;

    public function __construct(CommentarService $commentarService)
    {
        $this->commentarService = $commentarService;
    }

    public function store(Request $request)
    {
        $this->commentarService->store($request);
        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    public function update(Request $request, Comentar $comentar)
    {
        $this->commentarService->update($request, $comentar);
        return redirect()->back()->with('success', 'Komentar berhasil diperbarui!');
    }

    public function delete(Comentar $comentar)
    {
        $this->commentarService->delete($comentar);
        return redirect()->back()->with('success', 'Komentar berhasil dihapus!');
    }
}
