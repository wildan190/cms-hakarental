<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;

class WebBlogController extends Controller
{
    public function index(Request $request)
    {
        $cacheKey = 'web_blog_all';

        $blogs = Cache::store('redis')->remember($cacheKey, now()->addMinutes(10), function () {
            return Blog::where('status', 'publish')
                ->latest()
                ->get();
        });

        // Simpan cookie halaman yang sedang dilihat (hanya info, tidak memengaruhi data)
        $cookie = Cookie::make('last_blog_list_viewed', now()->toDateTimeString(), 60);

        return response()->json($blogs)->withCookie($cookie);
    }

    public function show($slug)
    {
        $cacheKey = "web_blog_slug_{$slug}";

        $blog = Cache::store('redis')->remember($cacheKey, now()->addMinutes(10), function () use ($slug) {
            return Blog::where('slug', $slug)
                ->where('status', 'publish')
                ->firstOrFail();
        });

        // Simpan cookie slug artikel terakhir yang dibuka
        $cookie = Cookie::make('last_blog_opened', $slug, 60);

        return response()->json($blog)->withCookie($cookie);
    }
}
