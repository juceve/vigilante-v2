@extends('layouts.app')

@section('template_title')
    Residencia
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Residencia') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('residencias.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
										<th>Cliente Id</th>
										<th>Propietario Id</th>
										<th>Cedula Propietario</th>
										<th>Numeropuerta</th>
										<th>Piso</th>
										<th>Calle</th>
										<th>Nrolote</th>
										<th>Manzano</th>
										<th>Notas</th>
										<th>Estado</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($residencias as $residencia)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $residencia->cliente_id }}</td>
											<td>{{ $residencia->propietario_id }}</td>
											<td>{{ $residencia->cedula_propietario }}</td>
											<td>{{ $residencia->numeropuerta }}</td>
											<td>{{ $residencia->piso }}</td>
											<td>{{ $residencia->calle }}</td>
											<td>{{ $residencia->nrolote }}</td>
											<td>{{ $residencia->manzano }}</td>
											<td>{{ $residencia->notas }}</td>
											<td>{{ $residencia->estado }}</td>

                                            <td>
                                                <form action="{{ route('residencias.destroy',$residencia->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('residencias.show',$residencia->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('residencias.edit',$residencia->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $residencias->links() !!}
            </div>
        </div>
    </div>
@endsection
