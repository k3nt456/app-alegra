@extends("layouts.home", ['page' => 'placeHistory'])
@section('title', 'Historial plaza')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.1/css/responsive.bootstrap5.css">
@endsection

@section('contenido')
    <h1>Historial de compras en la plaza</h1>
    <div class="card">
        <div class="card-body">
            <table id="placeHistory" class="table table-striped style=width:100%">
                <thead>
                    <tr>
                        <th>Alimento</th>
                        <th>Cantidad comprada</th>
                        <th>Tiempo ocupado en comprar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($placeHistorys as $placeHistory)
                        <tr>
                            <td>{{ $placeHistory['food_name'] }}</td>
                            <td>{{ $placeHistory['purchased_amount'] }}</td>
                            <td>{{ $placeHistory['busy_time'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.1/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.1/js/responsive.bootstrap5.js"></script>

    <script>
        new DataTable('#placeHistory', {
            responsive: true,
            autoWidth: false,
            "language": {
            "lengthMenu"    : "Mostrar _MENU_ registros por página",
            "zeroRecords"   : "No se encontraron registros",
            "info"          : "Mostrando la página _PAGE_ de _PAGES_",
            "infoEmpty"     : "Sin información disponible",
            "infoFiltered"  : "(Filtrado de _MAX_ registros totales)",
            "search"        : "Buscar:",
            "paginate"      : {
                "first"   : "Primero",
                "last"    : "Último",
                "next"    : "Siguiente",
                "previous": "Anterior"
            }
        }
        });
    </script>
@endsection
