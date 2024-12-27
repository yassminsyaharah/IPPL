@if (Route::currentRouteName() == 'onboarding')
    <style>
        .navbar {
            position: absolute;
            /* Allows content to overlap */
            top: 0;
            left: 0;
            width: 100%;
            z-index: 0;
            /* Ensures navbar stays on top */
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: transparent;
            /* Keeps navbar transparent */
            padding: 20px 10px;
            font-family: "Montserrat", serif;
        }

        .navbar a {
            text-decoration: none;
            color: #000;
            margin: 0 15px;
            font-size: 16px;
            position: relative;
            padding-bottom: 5px;
        }

        .navbar a:hover {
            color: #000;
        }

        .navbar a.active {
            color: #000;
        }

        .navbar a.active::after {
            content: "";
            display: block;
            width: 100%;
            height: 2px;
            background-color: #90ee90;
            position: absolute;
            bottom: 0;
            left: 0;
        }

        .navbar-brand.fw-semibold {
            color: #ffffff;
        }

        .nav-link.fw-medium {
            color: #ffffff;
        }
    </style>
@else
    <style>
        .navbar {
            /* Allows content to overlap */
            width: 100%;
            z-index: 0;
            /* Ensures navbar stays on top */
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: white;
            /* Keeps navbar transparent */
            padding: 20px 10px;
            font-family: "Montserrat", serif;
            border-bottom: 5px solid rgba(125, 125, 125, 0.25);
            /* Adds a bottom border with transparency to act as a shadow */
        }

        .navbar a {
            text-decoration: none;
            color: #000;
            margin: 0 15px;
            font-size: 16px;
            position: relative;
            padding-bottom: 5px;
        }

        .navbar a:hover {
            color: #000;
        }

        .navbar a.active {
            color: #000;
        }

        .navbar a.active::after {
            content: "";
            display: block;
            width: 100%;
            height: 2px;
            background-color: #90ee90;
            position: absolute;
            bottom: 0;
            left: 0;
        }

        .navbar-brand.fw-semibold {
            color: #000000;
        }

        .nav-link.fw-medium {
            color: #000000;
        }
    </style>
@endif

<nav class="navbar navbar-expand-md bg-transparent">
    <div class="container-fluid">
        <a class="navbar-brand fw-semibold" href="{{ route('home') }}">{{ config('app.name', 'Laravel') }}</a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav" type="button" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link fw-medium" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-medium" href="{{ route('recommendations') }}">Recommendations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-medium" href="{{ route('bookmarks') }}">Bookmarks</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item fw-semibold" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" style="display: none;" action="{{ route('logout') }}" method="POST">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
