@extends('bootstrap')

@section('title', "Login")

@section('content')
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
        }

        .form-signin {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
        }

        .form-signin .checkbox {
            font-weight: 400;
        }

        .form-signin .form-floating:focus-within {
            z-index: 2;
        }

        #name, #email {
            border-radius: 0;
            border-bottom: 0;
        }

        .form-signin input[name="last_name"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

    </style>
    <form method="post" action="./registration" class="form-signin text-center needs-validation" novalidate>
        @csrf
        <div class="form-floating">
            <input type="text" class="form-control @error('last_name') is-invalid @elseif($errors->any()) is-valid @enderror"
                   id="last_name" name="last_name" placeholder="Last Name" value="{{ old('last_name') }}" required>
            <label for="last_name">Last Name</label>
            @error('last_name')
            <div class="invalid-tooltip" id="message_last_name">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-floating">
            <input type="text" class="form-control @error('name') is-invalid @elseif($errors->any()) is-valid @enderror"
                   id="name" name="name" placeholder="Name" value="{{ old('name') }}" required>
            <label for="name">Name</label>
            @error('name')
            <div class="invalid-tooltip" id="message_name">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-floating">
            <input type="email" class="form-control @error('email') is-invalid @elseif($errors->any()) is-valid @enderror"
                   id="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
            <label for="email">Email address</label>
            @error('email')
            <div class="invalid-tooltip" id="message_name">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-floating">
            <input type="password" class="form-control @error('password') is-invalid @elseif($errors->any()) is-valid @enderror"
                   id="floatingPassword" placeholder="Password" name="password" required>
            <label for="floatingPassword">Password</label>
            @error('password')
            <div class="invalid-tooltip" id="message_name">
                {{ $message }}
            </div>
            @enderror
        </div>
        <button class="w-100 btn btn-lg btn-outline-success mt-3" type="submit">Sign-up</button>
        <a href="./login" class="w-100 btn btn-lg btn-outline-success mt-3">Login</a>
        <p class="mt-5 mb-3 text-muted">&copy; <?php echo date('Y');?></p>
    </form>
    <script>
        let objInputs = document.querySelectorAll('input');
        objInputs.forEach(function (objInput) {
            if ('form-control  is-invalid ' === objInput.className) {
                objInput.addEventListener('input', function () {
                    console.log('hit');
                    objInput.className = 'form-control is-valid';
                    document.getElementById('message_' + objInput.name).remove();
                });
            }
        });
    </script>
@endsection
