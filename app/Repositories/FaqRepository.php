<?php

namespace App\Repositories;

use App\Models\Faq;
use Illuminate\Http\Request;
use App\Repositories\Interface\FaqRepositoryInterface;

class FaqRepository implements FaqRepositoryInterface
{
    public function index()
    {
        return Faq::latest()->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        return Faq::create($request->only(['title', 'description']));
    }

    public function show($id)
    {
        return Faq::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $faq->update($request->only(['title', 'description']));
        return $faq;
    }

    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        return $faq->delete();
    }
}
