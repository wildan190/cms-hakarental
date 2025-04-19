<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WebMobilController extends Controller
{
    public function index(Request $request)
    {
        // Buat cache key unik berdasarkan parameter query
        $cacheKey = 'web_mobil_' . md5(json_encode($request->all()));

        // Cache selama 10 menit
        $mobilData = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($request) {
            $mobil = Mobil::query();

            // Search (nama, merk, type)
            if ($request->has('search')) {
                $search = strtolower($request->search);
                $mobil->where(function ($q) use ($search) {
                    $q->whereRaw('LOWER(name) LIKE ?', ["%$search%"])
                        ->orWhereRaw('LOWER(merk) LIKE ?', ["%$search%"])
                        ->orWhereRaw('LOWER(type) LIKE ?', ["%$search%"]);
                });
            }

            // Filter: jumlah seat
            if ($request->has('seat')) {
                $mobil->where('seat', $request->seat);
            }

            // Filter: merk
            if ($request->has('merk')) {
                $merk = strtolower($request->merk);
                $mobil->whereRaw('LOWER(merk) = ?', [$merk]);
            }

            // Filter: transmission (otomatis / manual)
            if ($request->has('transmission')) {
                $transmission = strtolower($request->transmission);
                $mobil->whereRaw('LOWER(transmission) = ?', [$transmission]);
            }

            return $mobil->latest()->get();
        });

        return response()->json($mobilData);
    }
}
