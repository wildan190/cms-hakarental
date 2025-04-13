<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Blog;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil semua blog milik user yang sedang login
        $blogs = Blog::where('user_id', $user->id)->latest()->get();

        return response()->json([
            'message' => 'Hello World, ' . $user->name,
            'blogs' => $blogs,
        ]);
    }
}
