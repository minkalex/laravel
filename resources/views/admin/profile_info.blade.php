@extends('layouts.profile')

@section('title', 'Your Profile')

@section('content')
    <div class="w-100 p-3">
        @if (Session::exists('profile_edited'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                <strong>{{ Session::get('profile_edited') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Well done!</h4>
            <p>Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content.</p>
            <hr>
            <p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p>
        </div>
    </div>
@endsection
