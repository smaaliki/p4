<nav class='sitenav'>
    <ul>
        <!-- Check if user is logged in and decide which nav bar to show -->
        @foreach(config('app.nav'.Auth::check()) as $link => $label)
            <li>
                <a href='{{ $link }}' class='{{ Request::is(substr($link, 1)) ? 'active' : '' }}'>
                    {{ $label }}
                </a>
            </li>
        @endforeach

        @if(Auth::check())
            <li>
                <form method='POST' id='logout' action='/logout'>
                    {{ csrf_field() }}
                    <a href='#' onClick='document.getElementById("logout").submit();'> {{ $user->name }}</a>
                </form>
            </li>
        @endif
    </ul>
</nav>
