<?php

namespace App\Repositories;

use App\Models\Blog;
use App\Repositories\Interface\BlogRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blogs', 'public');
        }

        $blog = Blog::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'slug' => Str::slug($request->title).'-'.uniqid(),
            'image' => $imagePath,
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // hapus gambar lama
            if ($blog->image && Storage::disk('public')->exists($blog->image)) {
                Storage::disk('public')->delete($blog->image);
            }

            $blog->image = $request->file('image')->store('blogs', 'public');
        }

        if ($request->filled('title')) {
            $blog->title = $request->title;
            $blog->slug = Str::slug($request->title).'-'.uniqid();
        }

        if ($request->filled('content')) {
            $blog->content = $request->content;
        }

        if ($request->filled('status')) {
            $blog->status = $request->status;
            $blog->date_published = $request->status === 'publish' ? now() : null;
        }

        $blog->save(); // wajib!

        return response()->json($blog);
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        // Hapus file gambar jika ada
        if ($blog->image && Storage::disk('public')->exists($blog->image)) {
            Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();

        return response()->json(['message' => 'Blog and image deleted successfully']);
    }
}
