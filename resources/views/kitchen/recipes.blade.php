@extends('layouts.home', ['page' => 'recipes'])
@section('title', 'Recetas')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/kitchen/css/styles.css') }}">
@endsection

@section('contenido')

    <header>
        <section id="container-slider">
            <a href="javascript: fntExecuteSlide('prev');" class="arrowPrev"><i class="fas fa-chevron-circle-left"></i></a>
            <a href="javascript: fntExecuteSlide('next');" class="arrowNext"><i class="fas fa-chevron-circle-right"></i></a>
            <ul class="listslider">
                <li><a itlist="itList_0" href="#" class="item-select-slid"></a></li>
                <li><a itlist="itList_1" href="#"></a></li>
                <li><a itlist="itList_2" href="#"></a></li>
                <li><a itlist="itList_3" href="#"></a></li>
                <li><a itlist="itList_4" href="#"></a></li>
                <li><a itlist="itList_5" href="#"></a></li>
            </ul>
            <ul id="slider" class="rounded">
                @foreach ($recipesTransformed as $key => $recipe)
                    @if ($key == 0)
                        <li
                            style="background-image: url('{{ asset('assets/kitchen/img/' . ($key + 1) . '.webp') }}'); z-index:0; opacity: 1;">
                            <div class="content_slider">
                                <div>
                                    <h2 class="font-monospace">{{ $recipe['name'] }}</h2>
                                    <p class="fw-normal">{{ $recipe['preparation'] }}</p>
                                    <p>Cantidad de pedidos: {{ $recipe['dishes_delivered'] }}</p>
                                    <div>
                                        <h3 style="text-align: left">Ingredientes</h3>
                                        <div class="list">
                                            @foreach ($recipe['ingredients'] as $ingredient)
                                                <div style="text-align: left">📝 {{ $ingredient }}</div>
                                            @endforeach
                                        </div>

                                        <a href="#" class="btnSlider">Ver más</a>
                                    </div>

                                </div>
                            </div>
                        </li>
                    @else
                        <li style="background-image: url('{{ asset('assets/kitchen/img/' . ($key + 1) . '.webp') }}')">
                            <div class="content_slider">
                                <div>
                                    <h2 class="font-monospace">{{ $recipe['name'] }}</h2>
                                    <p class="fw-normal">{{ $recipe['preparation'] }}</p>
                                    <p>Cantidad de pedidos: {{ $recipe['dishes_delivered'] }}</p>
                                    <h3 style="text-align: left">Ingredientes</h3>
                                    <div class="list">
                                        @foreach ($recipe['ingredients'] as $ingredient)
                                            <div style="text-align: left">📝 {{ $ingredient }}</div>
                                        @endforeach
                                    </div>
                                    <a href="#" class="btnSlider">Ver más</a>
                                </div>
                            </div>
                        </li>
                    @endif
                @endforeach
            </ul>
        </section>
    </header>
@endsection

@section('js')
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <script defer src={{ asset('assets/kitchen/js/functions.js') }}></script>
@endsection
