<nav class='sitenav'>
    <ul>
        @foreach(config('app.nav') as $link => $label)
        <li>
            <a href='{{ $link }}' class='{{ Request::is(substr($link, 1)) ? ' active' : '' }}'>{{ $label }}</a>
        </li>
        @endforeach
    </ul>
</nav>