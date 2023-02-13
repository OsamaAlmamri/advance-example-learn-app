<?php

namespace App\Http\Controllers;

use App\Models\Chanal;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    //

    public function create()
    {

        return view('posts.create');
    }


}
