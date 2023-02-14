<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\QueryFilters\Active;
use App\QueryFilters\MaxCount;
use App\QueryFilters\Sort;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class PostController extends Controller
{
    //

    public function index()

    {
//        $posts = Post::all();
//http://127.0.0.1:8000/posts?active=1&sort=desc&limit=3
        $pipeline = app(Pipeline::class,)->send(Post::query())->through([
            Active::class, Sort::class, MaxCount::class
        ])->thenReturn()->paginate(5);
//        return  dd($pipeline);
        return view('posts.index')->with('posts', $pipeline);
    }
}
