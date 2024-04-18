@extends('layouts.home', ['page' => 'kitchen'])
@section('title', 'Cocina')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/kitchen/css/styles.css') }}">
@endsection

@section('contenido')
    <!-- Elemento para mostrar el mensaje de error como un toast -->
    <div id="error-message" class="toast align-items-center text-white bg-danger p-2" role="alert" aria-live="assertive"
        aria-atomic="true" style="position: fixed; bottom: 20px; right: 20px; width: 300px; display: none;">
        <div class="d-flex">
            <div class="toast-body">
                <!-- El mensaje de error se mostrará aquí -->
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Cerrar"></button>
        </div>
    </div>

    <div class="container">
        <!-- Capa de opacidad y mensaje de carga -->
        <div class="overlay">
            <div class="loading-container">
                <img src="{{ asset('assets/kitchen/img/homero-cocinando.gif') }}" alt="Homero cocinando"
                    class="loading-gif">
                <div class="loading-message">Los platillos se están preparando 🧑‍🍳</div>
            </div>
        </div>

        <!-- Contenido principal de la página -->
        <h1 class="text-center p-5 margin_tittle">Esperando su selección para cocinar 🧑‍🍳 <br>Elija entre un plato o una
            cantidad personalizada de hasta 5</h1>

        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-4">
                <form method="POST" action="{{ route('kitchen-orders', ['count' => 1]) }}">
                    @csrf
                    <button type="submit" class="btn">
                        <img src="{{ asset('assets/kitchen/img/olla1.png') }}" alt="Imagen de olla" class="img-fluid"
                            style="max-width: 100px;">
                    </button>
                </form>
                <p>Ordenar un plato</p>
            </div>

            <div class="col-md-6 text-center mb-4">
                <form method="POST" action="{{ route('kitchen-orders') }}">
                    @csrf
                    <div class="input-group justify-content-center">
                        <input type="number" class="form_control text_input" name="count" min="1" max="6"
                            placeholder="Cantidad (1-5)" required>
                        <button type="submit" class="btn">
                            <img src="{{ asset('assets/kitchen/img/olla2.png') }}" alt="Imagen de olla 2" class="img-fluid"
                                style="max-width: 150px;">
                        </button>
                    </div>
                </form>
                <p>Orden para varios</p>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/kitchen/js/chargingScreen.js') }}"></script>
@endsection
