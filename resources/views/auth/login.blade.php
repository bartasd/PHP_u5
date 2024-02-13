@extends('layout_login')

@section('body')
    <div class="stabilizer">
        <div class="loginBrand"></div>
        <div class="stab2">
            <form class="loginForm" action="{{ route('login') }}" method="post">
                @csrf
                <label for="email"><b>e-Mail</b></label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                    autofocus>

                <label for="password"><b>Password</b></label>
                <input id="password" type="password" name="password" required autocomplete="current-password">

                <button class="submitBtn" type="submit">Login</button>
            </form>
        </div>
    </div>
@endsection
