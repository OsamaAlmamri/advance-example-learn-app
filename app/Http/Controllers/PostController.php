<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\QueryFilters\Active;
use App\QueryFilters\Sort;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class PostController extends Controller
{
    //

    public function index()

    {
//        $posts = Post::all();

        $pipeline = app(Pipeline::class,)->send(Post::query())->through([
            Active::class,Sort::class
        ])->thenReturn()->get();
//        return  dd($pipeline);
        return view('posts.index')->with('posts', $pipeline);
    }
}
