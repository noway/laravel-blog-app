<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyPostsController extends Controller
{
    public function index() {

        $posts = \App\Post::where("user_id", auth()->id())->get();
        return view('my-posts.index', compact('posts'));
    }
}
