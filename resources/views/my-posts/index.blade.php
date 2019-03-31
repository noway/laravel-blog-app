<h1>My Posts</h1>

@forelse ($posts as $post)
    <li>{{ $post->title }}</li>
@empty
    <p>No posts yet</p>
@endforelse

<a href="/posts/create">Create a post</a>
