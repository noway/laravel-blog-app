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
     * Get a validator for an incoming registration request.
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
        return view('posts.create');
    }

    /**
     * Handle a creation request for the post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $this->validator($data)->validate();

        // dd($data);

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

    // /**
    //  * Create a new user instance after a valid registration.
    //  *
    //  * @param  array  $data
    //  * @return \App\User
    //  */
    // protected function create(array $data)
    // {
    //     return User::create([
    //         'name' => $data['name'],
    //         'email' => $data['email'],
    //         'password' => Hash::make($data['password']),
    //     ]);
    // }
}
