@extends('layouts.app')

@section('template_title')
    Citememorandum
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Citememorandum') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('citememorandums.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
										<th>Empleado</th>
										<th>Empleado Id</th>
										<th>Cuerpo</th>
										<th>Estado</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($citememorandums as $citememorandum)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $citememorandum->correlativo }}</td>
											<td>{{ $citememorandum->gestion }}</td>
											<td>{{ $citememorandum->cite }}</td>
											<td>{{ $citememorandum->fecha }}</td>
											<td>{{ $citememorandum->fechaliteral }}</td>
											<td>{{ $citememorandum->empleado }}</td>
											<td>{{ $citememorandum->empleado_id }}</td>
											<td>{{ $citememorandum->cuerpo }}</td>
											<td>{{ $citememorandum->estado }}</td>

                                            <td>
                                                <form action="{{ route('citememorandums.destroy',$citememorandum->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('citememorandums.show',$citememorandum->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('citememorandums.edit',$citememorandum->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $citememorandums->links() !!}
            </div>
        </div>
    </div>
@endsection
