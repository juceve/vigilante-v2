@extends('layouts.app')

@section('template_title')
    Paseingreso
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Paseingreso') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('paseingresos.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
										<th>Residencia Id</th>
										<th>Nombre</th>
										<th>Cedula</th>
										<th>Fecha Inicio</th>
										<th>Fecha Fin</th>
										<th>Tipopase Id</th>
										<th>Detalles</th>
										<th>Url Foto</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($paseingresos as $paseingreso)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $paseingreso->residencia_id }}</td>
											<td>{{ $paseingreso->nombre }}</td>
											<td>{{ $paseingreso->cedula }}</td>
											<td>{{ $paseingreso->fecha_inicio }}</td>
											<td>{{ $paseingreso->fecha_fin }}</td>
											<td>{{ $paseingreso->tipopase_id }}</td>
											<td>{{ $paseingreso->detalles }}</td>
											<td>{{ $paseingreso->url_foto }}</td>

                                            <td>
                                                <form action="{{ route('paseingresos.destroy',$paseingreso->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('paseingresos.show',$paseingreso->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('paseingresos.edit',$paseingreso->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $paseingresos->links() !!}
            </div>
        </div>
    </div>
@endsection
