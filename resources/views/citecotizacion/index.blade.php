@extends('layouts.app')

@section('template_title')
    Citecotizacion
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Citecotizacion') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('citecotizacions.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
										<th>Correlativo</th>
										<th>Gestion</th>
										<th>Cite</th>
										<th>Fecha</th>
										<th>Fechaliteral</th>
										<th>Destinatario</th>
										<th>Cargo</th>
										<th>Monto</th>
										<th>Estado</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($citecotizacions as $citecotizacion)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $citecotizacion->correlativo }}</td>
											<td>{{ $citecotizacion->gestion }}</td>
											<td>{{ $citecotizacion->cite }}</td>
											<td>{{ $citecotizacion->fecha }}</td>
											<td>{{ $citecotizacion->fechaliteral }}</td>
											<td>{{ $citecotizacion->destinatario }}</td>
											<td>{{ $citecotizacion->cargo }}</td>
											<td>{{ $citecotizacion->monto }}</td>
											<td>{{ $citecotizacion->estado }}</td>

                                            <td>
                                                <form action="{{ route('citecotizacions.destroy',$citecotizacion->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('citecotizacions.show',$citecotizacion->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('citecotizacions.edit',$citecotizacion->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $citecotizacions->links() !!}
            </div>
        </div>
    </div>
@endsection
