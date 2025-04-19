<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Mobil;
use Illuminate\Http\Request;

class WebMobilController extends Controller
{
    public function index(Request $request)
    {
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

        return response()->json($mobil->latest()->get());
    }
}
