<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{

    /**
     * Show all blog posts.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = \App\Post::where("published", "1")->orderBy('published_at', 'desc')->get();
        $users = \App\User::all()->keyBy('id');
        return view('blog.index', compact('posts', 'users'));
    }
}
