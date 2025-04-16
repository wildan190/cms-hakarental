<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimoni;

class WebTestimoniController extends Controller
{
    // Tampilkan semua testimoni
    public function index()
    {
        $testimoni = Testimoni::latest()->get();

        return response()->json($testimoni);
    }

    // Simpan testimoni baru
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'rate'     => 'required|integer|min:1|max:5',
            'email'    => 'nullable|email|max:100',
            'feedback' => 'required|string',
        ]);

        $testimoni = Testimoni::create([
            'name'     => $request->name,
            'rate'     => $request->rate,
            'email'    => $request->email,
            'feedback' => $request->feedback,
        ]);

        return response()->json([
            'message'   => 'Testimoni berhasil disimpan',
            'testimoni' => $testimoni
        ], 201);
    }
}
