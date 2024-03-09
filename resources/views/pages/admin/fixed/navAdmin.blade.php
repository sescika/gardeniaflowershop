<ul class="nav nav-tabs">
    @foreach ($adminMenu as $i)
        <li class="nav-item">
            <a class="nav-link @if (request()->routeIs($i['route'])) active @endif" aria-current="page" href="{{ route($i['route']) }}">{{$i['name']}}</a>
        </li>
    @endforeach
</ul>
