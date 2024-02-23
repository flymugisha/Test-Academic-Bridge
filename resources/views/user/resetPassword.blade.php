<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome Icons  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
        integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
        crossorigin="anonymous" />

    <!-- Google Fonts  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Forgot Password UI Using CSS - @code.scientist x @codingtorque</title>
</head>

<body>
    <div class="card">
        @if (session()->has('success'))
            <div class=" text-danger" role="alert" style="color:blue;">
                <h6 class="alert-heading mb-1">Success!</h6>
                <span>{{ session()->get('success') }}</span>
            </div>
        @endif

        <form  action="{{ route('user.reset.post', ['token' => $token]) }}" method="POST">
            @csrf
            {{--  <p class="lock-icon">Reset Password</p>  --}}
            <h2>Forgot Password?</h2>
            <p>You can reset your Password here</p>
            <input type="password" class="passInput @error('password') is-invalid @enderror" name="password"
                placeholder="Email address">
            @error('password')
                <div class=" invalid-feedback" style="color: red;">{{ $errors->first('password') }}</div>
            @enderror
            <input type="password" class="passInput @error('confirm-password') is-invalid @enderror"
                name="confirm-password" placeholder="Email address">
            @error('confirm-password')
                <div class=" invalid-feedback" style="color: red;">{{ $errors->first('confirm-password') }}</div>
            @enderror
            <button type="submit" class="btn btn-primary d-grid w-100 mb-3">
                Set new password
            </button>

        </form>
    </div>
</body>

</html>
