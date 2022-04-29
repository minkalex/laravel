@extends('layouts.index')

@section('title', 'Authors')

@section('content')
    <div class="row" style="flex-wrap: unset; ">
        <div class="col-12">
            <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Добро пожаловать!</h4>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                    culpa qui officia deserunt mollit anim id est laborum</p>
                <hr>
                <p class="mb-0">Приятного времяпрепровождения.</p>
            </div>
            @if(Auth::check())
                <div class="d-flex justify-content-end">
                    <a href="{{ route('main') }}/chat" class="link-success">go to chats &rarr;</a>
                </div>
            @endif
        </div>
    </div>
@endsection
