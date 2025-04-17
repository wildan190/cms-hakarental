<?php

namespace App\Repositories;

use App\Models\Gallery;
use App\Repositories\Interface\GalleryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryRepository implements GalleryRepositoryInterface
{
    public function index()
    {
        return Gallery::latest()->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->file('image')->store('galleries', 'public');

        return Gallery::create([
            'title' => $request->title,
            'image' => $imagePath,
        ]);
    }

    public function show($id)
    {
        return Gallery::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
                Storage::disk('public')->delete($gallery->image);
            }

            $gallery->image = $request->file('image')->store('galleries', 'public');
        }

        $gallery->update($request->only(['title']));

        return $gallery;
    }

    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);

        if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
            Storage::disk('public')->delete($gallery->image);
        }

        $gallery->delete();

        return response()->json(['message' => 'Gallery item deleted successfully']);
    }
}
