<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\Mobil;
use App\Models\Testimoni;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $cachedData = Cache::remember('web_home_data', now()->addMinutes(10), function () {
            $gallery = Gallery::latest()->take(6)->get();

            $mobil = Mobil::where(function ($query) {
                $query->where('name', 'like', '%Avanza%')
                      ->orWhere('name', 'like', '%Sigra%')
                      ->orWhere('name', 'like', '%Reborn%')
                      ->orWhere('name', 'like', '%Zenix%');
            })->latest()->take(4)->get();

            $testimoni = Testimoni::latest()->take(6)->get();
            $faq = Faq::latest()->take(5)->get();

            return [
                'gallery' => $gallery,
                'mobil' => $mobil,
                'testimoni' => $testimoni,
                'faq' => $faq,
            ];
        });

        return response()->json($cachedData);
    }
}
