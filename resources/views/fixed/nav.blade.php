<nav class="navbar navbar-expand-lg text-uppercase bg-dark mb-3" data-bs-theme="dark">
    <div class="container">
        <a class="navbar-brand text-success" href="{{ route('home') }}">Gardenia</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                @foreach ($menu as $link)
                    <li class="nav-item">
                        <a class="nav-link @if (request()->routeIs($link->route)) active @endif"
                            href="{{ route($link->route) }}">{{ $link->name }}</a>
                    </li>
                @endforeach
                @if (Auth::user() && Auth::user()->role_id == 2)
                    <li class="nav-item dropdown-center">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Admin
                        </a>
                        <ul class="dropdown-menu">
                            @foreach ($adminMenu as $i)
                                <li><a class="dropdown-item" href="{{ route($i['route']) }}">{{ $i['name'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif
                @if (!Auth::check())
                    <li class="nav-item ">
                        <a class="nav-link @if (request()->routeIs('login')) active @endif "
                            href="{{ route('login') }}">Log in</a>
                    </li>
                @else
                    <li class="nav-item dropdown-center border rounded">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Welcome, <span class="text-success fw-bold">{{ Auth::user()->first_name }}
                                {{ Auth::user()->last_name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('profile', ['id' => Auth::user()->id]) }}">Profile
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                                    @csrf
                                    <a class="dropdown-item" href="#"
                                        onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">Log
                                        out
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
