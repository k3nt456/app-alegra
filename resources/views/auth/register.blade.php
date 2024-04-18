<!doctype html>
<html lang="en">

<head>
    <title>Registrar</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('assets/login/css/styles.css') }}">
</head>

<body>
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
        @if(session('error'))
            <div id="error-toast" class="toast align-items-center text-white bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
                </div>
            </div>
        @endif
    </div>
    <section class="h-100 size gradient-form" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card rounded-3 text-black">
                        <div class="row g-0">
                            <div class="col-lg-6">
                                <div class="card-body p-md-3 mx-md-4">

                                    <div class="text-center">
                                        <img src="{{ asset('assets/login/img/logo.png') }}" style="width: 185px;"
                                            alt="logo">
                                        <h4 class="mt-1 mb-1 pb-1">RESTAURANTE ALEATORIDAD</h4>
                                    </div>

                                    <form method="POST" action="{{ route('validate-register') }}">
                                        @csrf
                                        <p>Registrarse</p>
                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <label class="form-label" for="userInput">Nombre</label>
                                            <input type="text" name="name" id="userInput" class="form-control"
                                                placeholder="Nombre" required />
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <label class="form-label" for="emailInput">Correo</label>
                                            <input type="email" name="email" id="emailInput" class="form-control"
                                                placeholder="Correo electrónico" required />
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <label class="form-label" for="passwordInput">Contraseña</label>
                                            <input type="password" name="password" id="passwordInput"
                                                class="form-control" placeholder="**********" required />
                                        </div>

                                        <div class="text-center pt-1 mb-5 pb-1">
                                            <button data-mdb-button-init data-mdb-ripple-init
                                                class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-0"
                                                type="submit">Crear cuenta</button>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-center pb-0 pb-1.5">
                                            <p class="mb-2 me-2">Ya tengo una cuenta</p>
                                            <a href="{{ route('login') }}" data-mdb-button-init data-mdb-ripple-init
                                                class="btn btn-outline-danger">Iniciar sesión</a>
                                        </div>
                                    </form>

                                </div>
                            </div>
                            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                                <div class="text-white px-3 py-4 p-md-5 mx-md-4 text-center">
                                    <h4 class="mb-4">Ingresa ¡Gratis!</h4>
                                    <p class="small mb-0">Un reconocido restaurante ha decidido tener una jornada de
                                        donación de comida a los residentes de la región con la única condición de que
                                        el plato que obtendrán los comensales será aleatorio.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script>
        $(document).ready(function(){
            $('#error-toast').toast('show');

            setTimeout(function(){
                $('#error-toast').toast('hide');
            }, 4000);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
</body>

</html>
