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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show user's posts
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $posts = \App\Post::where("user_id", auth()->id())->orderBy('published_at', 'desc')->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Get a validator for an incoming post creation request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255'],
            'image' => ['required', 'string', 'url', 'max:255'],
            'content' => ['required', 'string'],
            'published' => [],
        ]);
    }

    /**
     * Validate post data for errors in the form
     *
     * @param  array  $data
     * @param  \App\Post  $post
     * @return void
     */
    protected function validatePostData(array $data, $post) {
        $collidingPost = \App\Post::where("slug", $data['slug'])->first();
        if ($collidingPost && (empty($post) || ($post && $post->id !== $collidingPost->id))) {
            $validator = Validator::make([], ['slug' => 'required'], ['required' => 'This slug already exists']);
            $validator->validate();
        }
        else{
            $this->validator($data)->validate();
        }
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
     * @param  string  $slug
     * @param  \Illuminate\Http\Request  $request
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
        $this->validatePostData($data, null);

        \App\Post::create([
            'user_id' => auth()->id(),
            'title' => $data['title'],
            'slug' => $data['slug'],
            'image' => $data['image'],
            'content' => $data['content'],
            'short_content' => substr($data['content'], 0, 1000),
            'published' => $data['published'] ?? '0',
            'published_at'=> ($data['published'] ?? '0') == "1" ? new \DateTime() : null,
        ]);

        return redirect('/posts');
    }

    /**
     * Handle an edit request for a post.
     *
     * @param  string  $slug
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit($slug, Request $request)
    {
        $data = $request->all();
        $post = \App\Post::where("slug", $slug)->first();
        if ($post && $post->user_id == auth()->id()) {
            $this->validatePostData($data, $post);

            $post->title = $data['title'];
            $post->slug = $data['slug'];
            $post->image = $data['image'];
            $post->content = $data['content'];
            $post->short_content = substr($data['content'], 0, 1000);
            $post->published = $data['published'] ?? '0';
            $post->published_at = ($data['published'] ?? '0') == "1" ? new \DateTime() : $post->published_at;
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
     * @param  string  $slug
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
