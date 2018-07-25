<!doctype html>
<html lang='en'>
<head>
    <title>@yield('title', 'CCMS')</title>
    <meta charset='utf-8'>

    <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
<!--    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet'>-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link href='/css/main.css' type='text/css' rel='stylesheet'>
    @stack('script')
    @stack('head')
</head>
<body>

<!-- Todo: Can we make the alert appear temporarily? -->
@if(session('alert'))
    <div class='flashAlert'>{{ session('alert') }}</div>
@endif

<header>
    <div class='logo'>
        <a href='/'><img src='/images/logo.png' id='logo' alt='Contact Center Management System Logo'/></a>
    </div>
    <!--<div class='username'>Login</div>-->
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

@stack('body')

</body>
</html>