<?php

namespace App\Repositories;

use App\Models\Testimoni;
use App\Repositories\Interface\TestimoniRepositoryInterface;
use Illuminate\Http\Request;

class TestimoniRepository implements TestimoniRepositoryInterface
{
    public function index()
    {
        return Testimoni::latest()->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'rate' => 'required|integer|min:1|max:5',
            'email' => 'nullable|email',
            'feedback' => 'required|string',
        ]);

        return Testimoni::create($request->only(['name', 'rate', 'email', 'feedback']));
    }

    public function show($id)
    {
        return Testimoni::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $testimoni = Testimoni::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string',
            'rate' => 'sometimes|required|integer|min:1|max:5',
            'email' => 'nullable|email',
            'feedback' => 'sometimes|required|string',
        ]);

        $testimoni->update($request->only(['name', 'rate', 'email', 'feedback']));

        return $testimoni;
    }

    public function destroy($id)
    {
        $testimoni = Testimoni::findOrFail($id);
        $testimoni->delete();

        return response()->json(['message' => 'Testimoni deleted successfully']);
    }
}
