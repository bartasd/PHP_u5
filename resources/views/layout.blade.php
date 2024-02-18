@php
    use Illuminate\Support\Facades\Request;
@endphp

<!DOCTYPE html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>U5 BANK</title>
    @vite(['resources/css/app.scss', 'resources/css/form.scss', 'resources/css/client.scss', 'resources/css/workField.scss', 'resources/css/font-awesome.min.css', 'resources/js/jquery-3.6.0.min.js', 'resources/js/app.js', 'resources/js/my.js'])

</head>

<body>
    <h1 class="logo">ELEPHANT BANK</h1>
    <div class="workField" id="vp">
        @php
            $messageIS = false;
            if (session()->has('message')) {
                $messageIS = true;
                $message = session('message');
                $type = session('type');
                session()->forget('message');
            }
        @endphp

        @if ($messageIS)
            <div id="msg_cont" class="message-box {{ $type }}-box">
                @if ($type == 'success')
                    <h1>SUCCESS!</h1>
                @else
                    <h1>ERROR!</h1>
                @endif

                <p>{{ $message }}</p>
                <button class="button check" id="check"><span><a>OK</a></span></button>
            </div>
        @endif


        @yield('body')
    </div>
    <div class="nav">
        <a href="{{ route('home') }}" class="{{ Request::routeIs('home') ? 'active activeLara' : '' }}"><i
                class="fa fa-home" aria-hidden="true"></i><span class="text">Home</span></a>
        <a href="{{ route('clients-accounts') }}"
            class="{{ Request::routeIs('clients-accounts') || Request::routeIs('clients-accounts.page') ? 'active activeLara' : '' }}"><i
                class="fa fa-users" aria-hidden="true"></i><span class="text">Accounts</span></a>
        <a href="{{ route('clients-create') }}"
            class="{{ Request::routeIs('clients-create') ? 'active activeLara' : '' }}"><i class="fa fa-plus"
                aria-hidden="true"></i><span class="text">Add Accounts</span></a>
        <a href="{{ route('accounts-transfer') }}"
            class="{{ Request::routeIs('accounts-transfer') ? 'active activeLara' : '' }}"><i class="fa fa-exchange"
                aria-hidden="true"></i><span class="text">Transfer</span></a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="reset">
            @csrf
            <button type="submit"><i class="fa fa-sign-out" aria-hidden="true"></i><span class="text">Log
                    Out</span></button>
        </form>
    </div>
</body>

</html>
