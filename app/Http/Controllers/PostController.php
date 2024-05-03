<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(10);

        return Inertia::render('Posts/Index', [
            'posts' => PostResource::collection($posts),
        ]);
    }
}
