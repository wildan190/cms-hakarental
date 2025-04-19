<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Support\Facades\Cache;

class WebBlogController extends Controller
{
    public function index()
    {
        $blogs = Cache::remember('web_blogs', now()->addMinutes(10), function () {
            return Blog::where('status', 'publish')
                ->latest()
                ->get();
        });

        return response()->json($blogs);
    }

    public function show($slug)
    {
        $cacheKey = 'web_blog_' . $slug;

        $blog = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($slug) {
            return Blog::where('slug', $slug)
                ->where('status', 'publish')
                ->firstOrFail();
        });

        return response()->json($blog);
    }
}
