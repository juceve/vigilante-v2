@extends('layouts.propietarios')

@section('title')
    Dashboard
@endsection

@section('header-title')
    Dashboard
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card bg-success available-balance-card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-0 text-white text-opacity-75">Pases Activos</p>
                            <h4 class="mb-0 text-white">10</h4>
                        </div>
                        <div class="avtar">
                            <a href="javascript:void(0)" class="text-reset text-decoration-none" title="Ver Detalles">
                                <i class="fas fa-search f-18"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card bg-primary available-balance-card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-0 text-white text-opacity-75">Flujo de Ingresos y Salidas del Día</p>
                            <h4 class="mb-0 text-white">37</h4>
                        </div>
                        <div class="avtar">
                            <a href="javascript:void(0)" class="text-reset text-decoration-none" title="Ver Detalles">
                                <i class="ti ti-arrows-left-right f-18"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">

        <div class="card">
            <div class="card-header">Card de Prueba</div>
            <div class="card-body">
                <h3>Texto de prueba</h3>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Vel minus, cupiditate nam voluptate itaque
                    magni illo illum sint consequatur rem aut maxime quas harum impedit sapiente ullam animi quos facilis,
                    corrupti necessitatibus natus sed. Minima alias reiciendis accusantium voluptates inventore sed
                    excepturi eaque quisquam expedita veniam deleniti similique, dolorum odio officia, illo ducimus amet quo
                    temporibus id nemo nostrum non maxime porro repellendus. Sapiente eveniet illo enim, neque dolorem quam
                    esse fugiat autem suscipit cupiditate impedit asperiores exercitationem deleniti a nam facilis cum
                    incidunt totam! Iste laborum nesciunt corporis modi, magni, pariatur eum in cupiditate, omnis recusandae
                    illo fugiat rerum?</p>
            </div>
        </div>
    </div>
@endsection
