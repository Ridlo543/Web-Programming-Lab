<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->query('search');

        $posts = Cache::remember('posts_search_' . md5($search), 60, function () use ($search) {
            return Post::query()
                ->when($search, function ($query, $search) {
                    return $query->where('title', 'like', "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%");
                })
                ->with('user') // Eager loading
                ->latest()
                ->paginate(10);
        });

        return view('posts.index', compact('posts', 'search'));
    }
}
