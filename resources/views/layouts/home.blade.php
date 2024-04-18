<!doctype html>
<html lang="en">

<head>
    <title>@yield('title', 'Menú principal')</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    @yield('css')
    <link rel="stylesheet" href="{{ asset('assets/home.css') }}">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand mt-2 mt-lg-0" href="#">
                    <img class="img-fluid" src="{{ asset('assets/login/img/logo.png') }}" height="50" width="50"
                        alt="Logo" loading="lazy" />
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                @php
                    if (!isset($page)) {
                        $page = 'kitchen';
                    }
                @endphp
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link {{ $page == 'kitchen' ? 'active_page' : '' }}"
                                href="{{ route('kitchen') }}">Cocina</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $page == 'recipes' ? 'active_page' : '' }}"
                                href="{{ route('recipes') }}">Recetas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $page == 'stock' ? 'active_page' : '' }}"
                                href="{{ route('stock') }}">Bodega</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $page == 'orders' ? 'active_page' : '' }}"
                                href="{{ route('orders') }}">Historial de pedidos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $page == 'placeHistory' ? 'active_page' : '' }}"
                                href="{{ route('place-history') }}">Historial de compras</a>
                        </li>
                    </ul>

                    <div class="d-flex align-items-center">
                        <a class="text-reset me-3" href="#">
                            <i class="fas fa-shopping-cart"></i>
                        </a>

                        <div>
                            <a class="d-flex align-items-center p-2 text-dark text-decoration-none">Bienvenido de nuevo
                                {{ auth()->user()->name }}</a>
                        </div>
                        <div>
                            <img src="https://mdbcdn.b-cdn.net/img/new/avatars/2.webp" class="rounded-circle"
                                height="25" alt="Black and White Portrait of a Man" loading="lazy" />
                            <a href="{{ route('logout') }}"><button type="button"
                                    class="m-3 btn btn-outline-primary me-2">Salir</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="container-fluid">
        @yield('contenido')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    @yield('js')
</body>

</html>
