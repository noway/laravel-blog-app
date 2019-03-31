@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('My Posts') }}</div>

                <div class="card-body">
                    <ul>
                        @forelse ($posts as $post)
                            <li><a href="/posts/edit/{{$post->slug}}">{{ $post->title }}</a></li>
                        @empty
                        <p>No posts yet</p>
                        @endforelse
                    </ul>
                    <div class="float-right"><a class="btn btn-sm btn-primary" href="/posts/create">New post</a></div>
                </div>
            </div>
            <br/>
            <div><a href="/home">↩ Dashboard</a></div>
        </div>
    </div>
</div>
@endsection
