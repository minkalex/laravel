@extends('layouts.profile')

@section('title', 'Edit Post')

@section('content')
    <div class="w-100 p-3">
        <div class="card">
            <h5 class="card-header">
                <div class="form-floating mb-3">
                    <input type="text"
                           class="form-control @error('title') is-invalid @elseif($errors->any()) is-valid @enderror"
                           value="{{ $objPost->title ? : old('title') }}" id="title" placeholder="Title" required
                           name="title">
                    <label for="title">Title</label>
                    @error('title')
                    <div class="invalid-tooltip" id="message_title">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </h5>
            <div class="card-body">
                <div class="form-floating mb-3">
                <textarea
                    class="form-control @error('description') is-invalid @elseif($errors->any()) is-valid @enderror"
                    placeholder="Type your post here" id="description" style="height: 100px" required
                    name="description">{{ $objPost->description ? : old('description') }}</textarea>
                    <label for="description">Type your post here</label>
                    @error('description')
                    <div class="invalid-tooltip" id="message_description">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <button type="button" class="btn btn-outline-success" onclick="editPost({{ $objPost->id }})">Save
                </button>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('add_post').className = 'nav-link active';

        let objTitle = document.getElementById('title');
        if ('form-control  is-invalid ' === objTitle.className) {
            objTitle.addEventListener('input', function () {
                objTitle.className = 'form-control is-valid';
                document.getElementById('message_title').remove();
            });
        }

        let objDescription = document.getElementById('description');
        if ('form-control  is-invalid ' === objDescription.className) {
            objDescription.addEventListener('input', function () {
                objDescription.className = 'form-control is-valid';
                document.getElementById('message_description').remove();
            });
        }

        function editPost(post_id) {
            let oReq = new XMLHttpRequest();
            let objForm = new FormData();
            objForm.append('_token', "{{ csrf_token() }}");
            objForm.append('title', document.getElementById('title').value);
            objForm.append('description', document.getElementById('description').value);
            oReq.open("PUT", "{{ route('main') }}/user/{{ \Illuminate\Support\Facades\Auth::id() }}/post/" + post_id + "/edit");
            oReq.send(objForm);
        }
    </script>

@endsection
