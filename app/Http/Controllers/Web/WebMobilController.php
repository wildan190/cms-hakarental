<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mobil;

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

        // Filter: seat
        if ($request->has('seat')) {
            $mobil->where('seat', $request->seat);
        }

        // Filter: merk
        if ($request->has('merk')) {
            $mobil->where('merk', $request->merk);
        }

        // Filter: transmission (otomatis / manual)
        if ($request->has('transmission')) {
            $mobil->where('transmission', $request->transmission);
        }

        return response()->json($mobil->latest()->get());
    }
}
