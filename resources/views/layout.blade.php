@php
    use Illuminate\Support\Facades\Request;
@endphp

<!DOCTYPE html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>U5 BANK</title>
    @vite(['resources/css/app.scss', 'resources/css/font-awesome.min.css', 'resources/js/jquery-3.6.0.min.js', 'resources/css/workField.scss', 'resources/js/app.js'])

</head>

<body>
    <div class="workField" id="vp">
        @yield('body')
    </div>
    <div class="nav">
        <a href="{{ route('start') }}" class="{{ Request::routeIs('start') ? 'active activeLara' : '' }}"><i
                class="fa fa-home" aria-hidden="true"></i><span class="text">Home</span></a>
        <a href="{{ route('accounts') }}" class="{{ Request::routeIs('accounts') ? 'active activeLara' : '' }}"><i
                class="fa fa-users" aria-hidden="true"></i><span class="text">Accounts</span></a>
        <a href="{{ route('add') }}" class="{{ Request::routeIs('add') ? 'active activeLara' : '' }}"><i
                class="fa fa-plus" aria-hidden="true"></i><span class="text">Add Accounts</span></a>
        <a href="{{ route('transfer') }}" class="{{ Request::routeIs('transfer') ? 'active activeLara' : '' }}"><i
                class="fa fa-exchange" aria-hidden="true"></i><span class="text">Transfer Funds</span></a>
    </div>
</body>

</html>
