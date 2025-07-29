<div>
    @section('title')
    VISITAS
    @endsection
    <div class="row mb-3">
        <div class="col-2">
            <a href="{{ route('home') }}" class="text-silver"><i class="fas fa-arrow-circle-left fa-2x"></i></a>
        </div>
        <div class="col-8">
            <h6 class="text-secondary text-center">REGISTRO ELECTRONICO DE VISTAS Y SALIDAS</h6>
        </div>
        <div class="col-2"></div>
    </div>

    <div class="container text-center mt-3">
        <img src="{{ asset('images/blackbird1.png') }}" class="img-fluid" style="width: 150px">
    </div>
    <div class="content mt-3">
        <b>
            <h3 class="text-primary text-center">{{ $designacion->turno->cliente->nombre }}</h3>
        </b>
        <div class="row g-1 mt-4">
            <div class="col-6 text-center">

                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-8 d-grid">
                        <a href="{{route('vigilancia.regingreso',$designacion->id)}}" class="btn btn-success"><strong><i
                                    class="fas fa-sign-in-alt"></i>
                                INGRESOS</strong></a>
                        <br>
                        <small class="text-success fw-bold">Ingresos Hoy:</small>
                        <h4 class="form-control mt-2">{{$visitas->count()}}</h4>
                    </div>
                </div>

            </div>
            <div class="col-6 text-center align-items-center">

                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-8 d-grid">
                        <a href="{{route('vigilancia.regsalida',$designacion->id)}}" class="btn btn-danger"><strong><i
                                    class="fas fa-sign-out-alt"></i>
                                SALIDAS</strong></a>
                        <br>
                        <small class="text-danger fw-bold">Salidas Hoy:</small>
                        <h4 class="form-control mt-2">{{$visitas->where('estado',0)->count()}}</h4>
                    </div>
                </div>

            </div>
            <div class="col-6">

            </div>
        </div>
    </div>
</div>