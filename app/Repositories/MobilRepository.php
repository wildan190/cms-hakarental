<?php

namespace App\Repositories;

use App\Models\Mobil;
use App\Repositories\Interface\MobilRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MobilRepository implements MobilRepositoryInterface
{
    public function index()
    {
        return Mobil::latest()->get();
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'type' => 'required|string',
                'merk' => 'required|string',
                'description' => 'required|string',
                'transmission' => 'required|string',
                'seat' => 'required|integer',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
    
            $imagePath = null;
    
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('mobils', 'public');
            }
    
            $mobil = Mobil::create([
                'name' => $request->name,
                'type' => $request->type,
                'merk' => $request->merk,
                'description' => $request->description,
                'transmission' => $request->transmission,
                'seat' => $request->seat,
                'image' => $imagePath
            ]);
    
            return response()->json([
                'message' => 'Mobil berhasil disimpan',
                'data' => $mobil
            ], 201);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan mobil',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    

    public function show($id)
    {
        return Mobil::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $mobil = Mobil::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'type' => 'sometimes|required|string',
            'merk' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'transmission' => 'sometimes|required|string',
            'seat' => 'sometimes|required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($mobil->image && Storage::disk('public')->exists($mobil->image)) {
                Storage::disk('public')->delete($mobil->image);
            }

            $mobil->image = $request->file('image')->store('mobils', 'public');
        }

        $mobil->update($request->only(['name', 'type', 'merk', 'description', 'transmission', 'seat']));

        return $mobil;
    }

    public function destroy($id)
    {
        $mobil = Mobil::findOrFail($id);

        if ($mobil->image && Storage::disk('public')->exists($mobil->image)) {
            Storage::disk('public')->delete($mobil->image);
        }

        $mobil->delete();

        return response()->json(['message' => 'Mobil deleted successfully']);
    }
}
