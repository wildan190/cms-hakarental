<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\Mobil;
use App\Models\Testimoni;

class HomeController extends Controller
{
    public function index()
    {
        $gallery = Gallery::latest()->take(6)->get();
        $mobil = Mobil::where(function ($query) {
            $query->where('nama_mobil', 'like', '%Avanza%')
                  ->orWhere('nama_mobil', 'like', '%Sigra%')
                  ->orWhere('nama_mobil', 'like', '%Reborn%')
                  ->orWhere('nama_mobil', 'like', '%Zenix%');
        })
        ->latest()
        ->take(4)
        ->get();
        
        $testimoni = Testimoni::latest()->take(6)->get();

        $faq = Faq::latest()->take(5)->get();

        return response()->json([
            'gallery' => $gallery,
            'mobil' => $mobil,
            'testimoni' => $testimoni,
            'faq' => $faq,
        ]);
    }
}
