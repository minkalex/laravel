<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Sing-up</title>
</head>
<body>
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

        #name, #email, #password {
            border-radius: 0;
            border-bottom: 0;
        }

        .form-signin input[name="last_name"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[name="repeat_password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

    </style>
    <form method="post" action="./signup" class="form-signin text-center needs-validation" novalidate>
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
                   id="password" placeholder="Password" name="password" required>
            <label for="floatingPassword">Password</label>
            @error('password')
            <div class="invalid-tooltip" id="message_name">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-floating">
            <input type="password" class="form-control @if ($errors->has('repeat') || $errors->has('repeat_password')) is-invalid @elseif($errors->any()) is-valid @endif"
                   id="repeat_password" placeholder="Repeat Password" name="repeat_password" required>
            <label for="repeat_password">Repeat Password</label>
            @if ($errors->has('repeat') || $errors->has('repeat_password'))
            <div class="invalid-tooltip" id="message_name">
                {{ $errors->first('repeat') ? : $errors->first('repeat_password') }}
            </div>
            @endif
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
                    objInput.className = 'form-control is-valid';
                    document.getElementById('message_' + objInput.name).remove();
                });
            }
        });
    </script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>
</html>
