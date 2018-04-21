<!doctype html>
<html>
<head>
    <title>@yield('title', 'Some Title')</title>
    <meta charset='utf-8'>

    <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet'>
    <link href='css/main.css' type='text/css' rel='stylesheet'>

    @stack('head')
</head>
<body>

<header>
    <div class='logo'>
        <a href='/'><img src='images/logo.jpg' id='logo' alt='Entity  Logo'></a>
        <div id='hdrtitle'><?=config('app.name')?></div>
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