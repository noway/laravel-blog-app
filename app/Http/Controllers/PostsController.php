<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Posts Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles posts CRUD and validation
    |
    */

    public function index() {

        $posts = \App\Post::where("user_id", auth()->id())->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Get a validator for an incoming post creation request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255'],
            'image' => ['required', 'string', 'url', 'max:255'],
            'content' => ['required', 'string'],
            'published' => ['accepted'],
        ]);
    }

    /**
     * Show the post creation form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showPostCreationForm() {
        $post = null;
        return view('posts.create-edit', compact('post'));
    }

    /**
     * Show the post edit form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showPostEditForm($slug, Request $request) {
        $data = $request->all();
        $post = \App\Post::where("slug", $slug)->first();
        if ($post) {
            return view('posts.create-edit', compact('post'));
        }
        else {
            return redirect('/posts');
        }
    }

    /**
     * Handle a creation request for a post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $this->validator($data)->validate();

        \App\Post::create([
            'user_id' => auth()->id(),
            'title' => $data['title'],
            'slug' => $data['slug'],
            'image' => $data['image'],
            'content' => $data['content'],
            'short_content' => substr($data['content'], 0, 1000),
            'published' => $data['published'],
            'published_at'=> $data['published'] ? new \DateTime() : null,
        ]);

        return redirect('/posts');
    }

    /**
     * Handle an edit request for a post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit($slug, Request $request)
    {
        $data = $request->all();
        $post = \App\Post::where("slug", $slug)->first();
        if ($post && $post->user_id == auth()->id()) {
            $this->validator($data)->validate();

            $post->title = $data['title'];
            $post->slug = $data['slug'];
            $post->image = $data['image'];
            $post->content = $data['content'];
            $post->short_content = substr($data['content'], 0, 1000);
            $post->published = $data['published'];
            $post->published_at = $data['published'] ? new \DateTime() : $post->published_at;
            $post->save();
        }
        else {
            // silently proceed
        }

        return redirect('/posts');
    }

    /**
     * Handle a deletion request for a post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete($slug, Request $request)
    {
        $data = $request->all();
        $post = \App\Post::where("slug", $slug)->first();
        if ($post && $post->user_id == auth()->id()) {
            $post->delete();
        }
        else {
            // silently proceed
        }
        return redirect('/posts');
    }

}
