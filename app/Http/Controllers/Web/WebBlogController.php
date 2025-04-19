<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class WebBlogController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $cacheKey = 'web_blogs_page_' . $page;

        $blogs = Cache::remember($cacheKey, now()->addMinutes(10), function () {
            return Blog::where('status', 'publish')
                ->latest()
                ->paginate(6);
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
