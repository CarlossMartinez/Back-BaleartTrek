<?php
namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Meeting;
use App\Models\Image;
use Illuminate\Support\Facades\File;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\StoreImageRequest;

class CommentCRUD extends Controller
{
    public function index()
    {
        $comments = Comment::with(['meeting', 'user', 'images'])
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        
        return view('commentCRUD.index', compact('comments'));
    }

    public function create()
    {
        $meetings = Meeting::pluck('id', 'day');

        return view('commentCRUD.create', compact('meetings'));
    }

    public function store(StoreCommentRequest $request)
    {
        Comment::create([
            'comment' => $request->comment,
            'score' => $request->score,
            'meeting_id' => $request->meeting_id,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('commentCRUD.index')
            ->with('success', 'Comentario creado correctamente');
    }

    public function show(Comment $comment)
    {
        $comment->load(['meeting', 'user', 'images']);

        return view('commentCRUD.show', compact('comment'));
    }

    public function edit(Comment $comment)
    {
        $meetings = Meeting::pluck('id', 'title');
        $comment->load('images');

        return view('commentCRUD.edit', compact('comment', 'meetings'));
    }

    public function update(StoreCommentRequest $request, Comment $comment)
    {
        $comment->update($request->all());

        return redirect()->route('comments.index')
            ->with('success', 'Comentario actualizado');
    }

    public function destroy(Comment $comment)
    {
        foreach ($comment->images as $image) {
            $imagePath = public_path('images/' . $image->url);

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }

            $image->delete();
        }

        $comment->delete();

        return redirect()->route('comments.index')
            ->with('success', 'Comentario eliminado');
    }

    public function image(StoreImageRequest $request, Comment $comment)
    {
        $filename = time() . '.' . $request->url->extension();

        $request->url->move(public_path('images'), $filename);

        Image::create([
            'url' => $filename,
            'comment_id' => $comment->id,
        ]);

        return back()->with('success', 'Imagen subida');
    }

    public function destroyImage(Image $image)
    {
        $imagePath = public_path('images/' . $image->url);

        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        $image->delete();

        return back()->with('success', 'Imagen eliminada');
    }
}