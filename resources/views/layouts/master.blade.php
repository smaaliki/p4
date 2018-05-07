<!doctype html>
<html lang='en'>
<head>
    <title>@yield('title', 'CCMS')</title>
    <meta charset='utf-8'>

    <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet'>
    <link href='/css/main.css' type='text/css' rel='stylesheet'>
    @stack('script')
    @stack('head')
</head>
<body>

@if(session('alert'))
    <div class='flashAlert'>{{ session('alert') }}</div>
@endif

<header>
    <div class='logo'>
        <a href='/'><img src='/images/logo.png' id='logo' alt='Contact Center Management System Logo'></a>
    </div>
    <div class='username'>Samer Maaliki</div>
    <div class='navigation'>
        @include('modules.nav')
    </div>
</header>

<section id='main'>
    @yield('content')
</section>

<footer>
    &copy; {{ date('Y') }} - Maaliki Corp
</footer>

<!--Todo: do we need this-->
{{--<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>--}}

@stack('body')

</body>
</html>