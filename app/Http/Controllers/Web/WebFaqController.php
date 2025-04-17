<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Faq;

class WebFaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::latest()->get();

        return response()->json([
            'message' => 'Data FAQ berhasil diambil',
            'data' => $faqs
        ]);
    }
}
