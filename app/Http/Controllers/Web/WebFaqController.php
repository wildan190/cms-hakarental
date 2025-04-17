<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class WebFaqController extends Controller
{
    public function index(Request $request)
    {
        $query = Faq::query();

        // Jika ada parameter search
        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                  ->orWhere('description', 'LIKE', "%{$keyword}%");
            });
        }

        $faqs = $query->latest()->get();

        return response()->json([
            'message' => 'Data FAQ berhasil diambil',
            'data' => $faqs
        ]);
    }
}
