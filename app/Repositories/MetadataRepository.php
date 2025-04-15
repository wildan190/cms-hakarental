<?php

namespace App\Repositories;

use App\Models\Metadata;
use App\Repositories\Interface\MetadataRepositoryInterface;
use Illuminate\Http\Request;

class MetadataRepository implements MetadataRepositoryInterface
{
    public function index()
    {
        return Metadata::latest()->first(); // Ambil entri pertama saja
    }

    public function store(Request $request)
    {
        // Cek jika sudah ada data metadata
        if (Metadata::count() >= 1) {
            return response()->json(['message' => 'Metadata already exists, please update the existing data.'], 400);
        }

        $request->validate([
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'facebook' => 'nullable|string',
            'instagram' => 'nullable|string',
            'twitter' => 'nullable|string',
            'linkedin' => 'nullable|string',
            'website_name' => 'nullable|string',
        ]);

        return Metadata::create($request->only([
            'phone', 
            'email', 
            'address', 
            'facebook', 
            'instagram', 
            'twitter', 
            'linkedin', 
            'website_name'
        ]));
    }

    public function show($id)
    {
        return Metadata::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $metadata = Metadata::first(); // Karena hanya ada satu data
        $metadata->update($request->only([
            'phone', 
            'email', 
            'address', 
            'facebook', 
            'instagram', 
            'twitter', 
            'linkedin', 
            'website_name'
        ]));

        return $metadata;
    }

    public function destroy($id)
    {
        $metadata = Metadata::first(); // Ambil satu-satunya entri
        $metadata->delete();

        return response()->json(['message' => 'Metadata deleted successfully']);
    }
}
