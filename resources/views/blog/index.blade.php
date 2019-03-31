<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Blog</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link href="/css/app.css" rel="stylesheet">
    </head>
    <body>
        <div class="flex-top position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content m-t-lg">
                @forelse ($posts as $post)
                    <article class="m-b-sm">
                        <h1>{{ $post->title }}</h1>
                        <div class="post-content">{{ $post->content }}</div>
                        <details open class="m-t-xs f-sm">Published on <time datetime="{{ $post->published_at }}">{{ $post->published_at->format('F jS, Y, g:i a') }}</time> {{ $post->user_id ? 'by ' .$users[$post->user_id]->name : '' }}</details>
                    </article>
                @empty
                <p>No blog posts yet</p>
                @endforelse

            </div>
        </div>
    </body>
</html>
