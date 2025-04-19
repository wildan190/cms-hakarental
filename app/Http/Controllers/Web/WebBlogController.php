<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

class WebBlogController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = 6;
        $cacheKey = "web_blogs_page_{$page}";

        $blogs = Cache::store('redis')->remember($cacheKey, now()->addMinutes(10), function () use ($perPage) {
            return Blog::where('status', 'publish')
                ->latest()
                ->paginate($perPage);
        });

        $cookie = Cookie::make('last_blog_page', $page, 60);

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
    
        // Ambil topik terkait (tanpa blog yang sedang ditampilkan)
        $related = Cache::store('redis')->remember("web_blog_related_exclude_{$slug}", now()->addMinutes(10), function () use ($slug) {
            return Blog::where('slug', '!=', $slug)
                ->where('status', 'publish')
                ->latest()
                ->take(3)
                ->get();
        });
    
        return response()->json([
            'blog' => $blog,
            'related' => $related,
        ]);
    }
    
}
