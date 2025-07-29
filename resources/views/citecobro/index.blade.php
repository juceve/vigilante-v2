@extends('layouts.app')

@section('template_title')
    Citecobro
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Citecobro') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('citecobros.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
										<th>Cliente</th>
										<th>Cliente Id</th>
										<th>Representante</th>
										<th>Mescobro</th>
										<th>Factura</th>
										<th>Monto</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($citecobros as $citecobro)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $citecobro->correlativo }}</td>
											<td>{{ $citecobro->gestion }}</td>
											<td>{{ $citecobro->cite }}</td>
											<td>{{ $citecobro->fecha }}</td>
											<td>{{ $citecobro->fechaliteral }}</td>
											<td>{{ $citecobro->cliente }}</td>
											<td>{{ $citecobro->cliente_id }}</td>
											<td>{{ $citecobro->representante }}</td>
											<td>{{ $citecobro->mescobro }}</td>
											<td>{{ $citecobro->factura }}</td>
											<td>{{ $citecobro->monto }}</td>

                                            <td>
                                                <form action="{{ route('citecobros.destroy',$citecobro->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('citecobros.show',$citecobro->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('citecobros.edit',$citecobro->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $citecobros->links() !!}
            </div>
        </div>
    </div>
@endsection
