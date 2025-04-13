<?php

namespace App\Repositories;

use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interface\BlogRepositoryInterface;

class BlogRepository implements BlogRepositoryInterface
{
    public function index()
    {
        return Blog::with('user')->latest()->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'status' => 'required|in:publish,draft',
        ]);

        $blog = Blog::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . uniqid(),
            'content' => $request->content,
            'status' => $request->status,
            'date_published' => $request->status === 'publish' ? now() : null,
        ]);

        return response()->json($blog, 201);
    }

    public function show($id)
    {
        return Blog::with('user')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required',
            'status' => 'sometimes|in:publish,draft',
        ]);

        $blog->update([
            'title' => $request->title ?? $blog->title,
            'slug' => $request->title ? Str::slug($request->title) . '-' . uniqid() : $blog->slug,
            'content' => $request->content ?? $blog->content,
            'status' => $request->status ?? $blog->status,
            'date_published' => $request->status === 'publish' ? now() : $blog->date_published,
        ]);

        return response()->json($blog);
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return response()->json(['message' => 'Blog deleted successfully']);
    }
}
