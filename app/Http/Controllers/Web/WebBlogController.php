<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog;

class WebBlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::where('status', 'publish')
            ->latest()
            ->get();

        return response()->json($blogs);
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->where('status', 'publish')
            ->firstOrFail();

        return response()->json($blog);
    }
}
