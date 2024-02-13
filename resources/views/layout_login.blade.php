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
    @vite(['resources/css/app.scss', 'resources/css/login.scss', 'resources/css/workField.scss', 'resources/css/font-awesome.min.css', 'resources/js/jquery-3.6.0.min.js', 'resources/js/app.js'])

</head>

<body>
    <h1 class="logo">ELEPHANT BANK</h1>
    <div class="workField" id="vp">
        @yield('body')
    </div>

</body>

</html>
