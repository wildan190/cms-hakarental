<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Metadata;
use Illuminate\Support\Facades\Cache;

class WebKontakController extends Controller
{
    public function index()
    {
        // Cache selama 10 menit
        $metadata = Cache::remember('web_kontak_metadata', now()->addMinutes(10), function () {
            return Metadata::first();
        });

        return response()->json([
            'phone' => $metadata?->phone,
            'email' => $metadata?->email,
            'address' => $metadata?->address,
            'facebook' => $metadata?->facebook,
            'instagram' => $metadata?->instagram,
            'twitter' => $metadata?->twitter,
            'linkedin' => $metadata?->linkedin,
            'website_name' => $metadata?->website_name,
        ]);
    }
}
