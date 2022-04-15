@extends('layouts.index')

@section('title', "Posts by $user")

@section('content')
<div class="d-flex justify-content-end">
    <div class="btn-group mb-5" role="group" aria-label="Basic outlined example">
        <a href="{{ route('main') }}/login" class="btn btn-outline-success">Login</a>
        <a href="{{ route('main') }}/signup" class="btn btn-outline-success">Sign-up</a>
    </div>
</div>
<div class="row mb-5">
    <div class="col-4">
        <div class="list-group" id="list-tab" role="tablist">
            <li class="list-group-item list-group-item-success" aria-disabled="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-text-paragraph" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2 12.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm4-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5z"/>
                    </svg>
                    Posts by <b>{{ $user }}</b>

            </li>
            @foreach ($objPosts as $objPost)
                <a class="list-group-item list-group-item-action" id="post-{{ $objPost->id }}" data-bs-toggle="list" href="#list-post-{{ $objPost->id }}" role="tab" aria-controls="list-post-{{ $objPost->id }}">
                    {{ $objPost->title }}
                    <p class="text-end mb-0"><small>{{ $objPost->created_at->format('d.m.Y H:i') }}</small></p>
                </a>
            @endforeach
        </div>
    </div>
    <div class="col-8">
        <div class="tab-content" id="nav-tabContent">
            @foreach ($objPosts as $objPost)
                <div class="tab-pane fade" id="list-post-{{ $objPost->id }}" role="tabpanel" aria-labelledby="list-post-{{ $objPost->id }}-list">{{ $objPost->description }}</div>
            @endforeach
        </div>
    </div>
</div>
<nav class="mb-5">
    <ul class="pagination pagination justify-content-center">
        <li class="page-item disabled">
            <span class="page-link">Previous</span>
        </li>
        <li class="page-item active" aria-current="page">
            <span class="page-link">1</span>
        </li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
            <a class="page-link" href="#">Next</a>
        </li>
    </ul>
</nav>
<a href="{{ route('main') }}" type="button" class="btn btn-outline-success">&larr; Home</a>
@endsection
