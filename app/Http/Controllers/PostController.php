<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::latest()->paginate(10);

        if ($request->expectsJson()) {
            return PostResource::collection($posts);
        }

        return Inertia::render('Posts/Index', [
            'posts' => PostResource::collection($posts),
        ]);
    }
}
