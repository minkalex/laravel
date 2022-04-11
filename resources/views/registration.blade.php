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
    <form method="post" action="./validation" class="form-signin text-center">
        @csrf
        <div class="form-floating">
            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name">
            <label for="last_name">Last Name</label>
        </div>
        <div class="form-floating">
            <input type="text" class="form-control" id="name" name="name" placeholder="Name">
            <label for="name">Name</label>
        </div>
        <div class="form-floating">
            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
            <label for="email">Email address</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="pw">
            <label for="floatingPassword">Password</label>
        </div>
        <button class="w-100 btn btn-lg btn-outline-success mt-3" type="submit">Sign-up</button>
        <a href="./log_in" class="w-100 btn btn-lg btn-outline-success mt-3">Login</a>
        <p class="mt-5 mb-3 text-muted">&copy; <?php echo date('Y');?></p>
    </form>
@endsection
