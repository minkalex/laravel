@extends('layouts.profile')

@section('title', 'Your Posts')

@section('content')
    <div class="w-100 p-3">
        @if (Session::exists('post_add'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                <strong>{{ Session::get('post_add') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(empty($objPosts))
            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                    <path
                        d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </symbol>
            </svg>

            <div class="alert alert-warning d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:">
                    <use xlink:href="#exclamation-triangle-fill"/>
                </svg>
                <div>
                    Вы еще не имеете публикаций.
                </div>
            </div>
        @endif

        @foreach($objPosts as $index => $objPost)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $objPost->title }}</h5>
                    <p class="card-text">{{ $objPost->description }}</p>
                    <a href="{{ route('main') }}/blog/{{ $objPost->id }}/edit" class="btn btn-outline-success">Edit</a>
                    <a href="{{ route('main') }}/blog/{{ $objPost->id }}/delete" class="btn btn-outline-danger">Delete</a>
                </div>
                <div class="card-footer text-muted text-end">
                    {{ $objPost->created_at->format('d.m.Y H:i') }}
                </div>
            </div>
        @endforeach
    </div>
    <script>
        document.getElementById('posts').className = 'nav-link active';
        /*function deletePost(post_id)
        {
            if (window.confirm("Вы действительно хотите удалить пост?")) {
                let oReq = new XMLHttpRequest();
                let objForm = new FormData();
                objForm.append('_token', "{{ csrf_token() }}");
                oReq.open("DELETE", "{{ route('main') }}/user/{{ \Illuminate\Support\Facades\Auth::id() }}/post/" + post_id + "/delete");
                oReq.send(objForm);
            }
        }*/
    </script>
@endsection
