<!-- resources/views/components/navbar.blade.php -->

<style>
    .navbar {
        display: flex;
        justify-content: center;
        align-items: center;
        border-bottom: 3px solid #e0e0e0;
        /* Garis bawah navbar */
        background-color: #fff;
        /* Warna latar putih */
        padding: 10px 0;
        font-family: "Montserrat", serif;
    }

    .navbar a {
        text-decoration: none;
        color: #000;
        /* Warna teks */
        margin: 0 15px;
        /* Spasi antar item menu */
        font-size: 16px;
        position: relative;
        padding-bottom: 5px;
    }

    .navbar a:hover {
        color: #000;
        /* Tetap hitam saat hover */
    }

    .navbar a.active {
        color: #000;
        /* Warna teks item aktif */
    }

    .navbar a.active::after {
        content: "";
        display: block;
        width: 100%;
        height: 2px;
        background-color: #90ee90;
        /* Warna hijau muda */
        position: absolute;
        bottom: 0;
        left: 0;
    }
</style>

<nav class="navbar navbar-expand-md navbar-light bg-light fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-semibold" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav" type="button" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="{{ url('/recommendations') }}">Recommendations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="{{ url('/bookmarks') }}">Bookmarks</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link fw-semibold" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item fw-semibold" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
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
