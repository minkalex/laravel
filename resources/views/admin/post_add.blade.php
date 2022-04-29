@extends('layouts.profile')

@section('title', 'Add post')

@section('content')

<div class="w-100 p-3">
    <form action="" method="post">
        @csrf
        <div class="card">
            <h5 class="card-header">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control @error('title') is-invalid @elseif($errors->any()) is-valid @enderror"
                           value="{{ old('title') }}" id="title" placeholder="Title" required name="title">
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
                    <textarea class="form-control @error('description') is-invalid @elseif($errors->any()) is-valid @enderror"
                              placeholder="Type your post here" id="description" style="height: 100px" required name="description">{{ old('description') }}</textarea>
                    <label for="description">Type your post here</label>
                    @error('description')
                    <div class="invalid-tooltip" id="message_description">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-outline-success">Save</button>
            </div>
        </div>
    </form>
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
</script>

@endsection
