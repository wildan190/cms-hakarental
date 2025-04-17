<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Metadata;

class WebKontakController extends Controller
{
    public function index()
    {
        $metadata = Metadata::first();

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
