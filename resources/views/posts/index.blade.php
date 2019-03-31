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
                            <li class="m-b-xs">{{ $post->title }}&nbsp;{{$post->published == "1" ? '[Published]' : '[Not published]'}}&nbsp;<a href="/posts/{{$post->slug}}/edit" class="btn btn-sm btn-outline-primary">Edit</a>&nbsp;<a href="/posts/{{$post->slug}}/delete" class="btn btn-sm btn-outline-danger">Delete</a></li>
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
