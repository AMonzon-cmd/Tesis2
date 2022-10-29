@extends('layouts/layout')

@section('menu-dashboard')
    active
@endsection


@section('contenido')

    <!-- Migas de pan -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="javascript:;">Panel de Administración</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <!-- /Migas de pan-->

    @csrf
    <!-- Titulo Pagina -->
    <h1 class="page-header">Dashboard</h1>
    <!-- /Titulo Pagina -->

    <div class="row">
        <div class="col-3">
            <div class="widget widget-stats bg-gradient-green m-b-10">
                <div class="stats-icon stats-icon-lg"><i class="fas fa-comment-dollar"></i></div>
                <div class="stats-content">
                    <div class="stats-title font-weight-bold">PAGOS DEL DIA</div>
                    <br/>
                    <div class="stats-number"><span data-animation="number" data-value="{{$dashboard->pagosDelDia}}">0</span></div>
                    <div class="stats-desc"><a class="text-white" href="{{ruta('listadoPagos')}}">Ver mas -></a></div>
                </div>
            </div>
        </div>

        <div class="col-3">
            <div class="widget widget-stats bg-gradient-purple m-b-10">
                <div class="stats-icon stats-icon-lg"><i class="fas fa-comment-dollar"></i></div>
                <div class="stats-content">
                    <div class="stats-title font-weight-bold">PAGOS TOTALES</div>
                    <br/>
                    <div class="stats-number"><span data-animation="number" data-value="{{$dashboard->pagosTotales}}">0</span></div>
                    <div class="stats-desc"><a class="text-white" href="{{ruta('listadoPagos')}}">Ver mas -></a></div>
                </div>
            </div>
        </div>

        <div class="col-3">
            <div class="widget widget-stats bg-gradient-red m-b-10">
                <div class="stats-icon stats-icon-lg"><i class="fas fa-receipt"></i></div>
                <div class="stats-content">
                    <div class="stats-title font-weight-bold">PAGOS ANULADOS</div>
                    <br/>
                    <div class="stats-number"><span data-animation="number" data-value="{{$dashboard->pagosAnulados}}">0</span></div>
                    <div class="stats-desc"><a class="text-white" href="{{ruta('listadoPagos')}}">Ver mas -></a></div>
                </div>
            </div>
        </div>

        <div class="col-3">
            <div class="widget widget-stats bg-gradient-blue m-b-10">
                <div class="stats-icon stats-icon-lg"><i class="fas fa-user-plus"></i></div>
                <div class="stats-content">
                    <div class="stats-title font-weight-bold">NUEVOS CLIENTES</div>
                    <br/>
                    <div class="stats-number"><span data-animation="number" data-value="{{$dashboard->clientesNuevos}}">0</span></div>
                    <div class="stats-desc"><a class="text-white" href="{{ruta('clientes')}}">Ver mas -></a></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6 mt-3">
            <canvas id="myChart"></canvas>
        </div>
        <div class="col-1"></div>
        <div class="col-4 mt-2 text-center justify-content-center" style="max-width: 400px;">
            <h5>Top pago de servicios</h5>
            <canvas id="myChart2" ></canvas>
        </div>
    </div>


@endsection

@section('scripts')
<script>
    const labels = {!! json_encode($dashboard->fechasPagos) !!};

    const data = {
        labels: labels,
        datasets: [{
        label: 'Pagos realizados del mes',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: {!! json_encode($dashboard->valoresPagos) !!},
        }]
    };

    const data2 = {
    labels: {!! json_encode($dashboard->pagosPopulares) !!},
    datasets: [{
        label: 'Servicios populares',
        data: {!! json_encode($dashboard->cantidadPagosPopulares) !!},
        borderWidth: 1,
        backgroundColor: [
            '#85c1e9',
            '#a2d9ce',
            '#f9e79f',
            '#f1948a',
            '#bb8fce',
            '#34495e',
            '#1e8449',
            '#839192',
            '#21618c',
            '#839192',
            '#1f618d',
            '#6e2c00'
        ],
    }]
    };

    const config = {
        type: 'line',
        data: data,
        options: {}
    };

    const config2 = {
        type: 'doughnut',
        data: data2,
    };

    $(document).ready(function() {    
        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
        const myChart2 = new Chart(
            document.getElementById('myChart2'),
            config2
        );
    });
</script>
@endsection