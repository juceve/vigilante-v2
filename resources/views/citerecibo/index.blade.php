@extends('layouts.app')

@section('template_title')
    Citerecibo
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Citerecibo') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('citerecibos.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
										<th>Mescobro</th>
										<th>Monto</th>
										<th>Estado</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($citerecibos as $citerecibo)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $citerecibo->correlativo }}</td>
											<td>{{ $citerecibo->gestion }}</td>
											<td>{{ $citerecibo->cite }}</td>
											<td>{{ $citerecibo->fecha }}</td>
											<td>{{ $citerecibo->fechaliteral }}</td>
											<td>{{ $citerecibo->cliente }}</td>
											<td>{{ $citerecibo->cliente_id }}</td>
											<td>{{ $citerecibo->mescobro }}</td>
											<td>{{ $citerecibo->monto }}</td>
											<td>{{ $citerecibo->estado }}</td>

                                            <td>
                                                <form action="{{ route('citerecibos.destroy',$citerecibo->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('citerecibos.show',$citerecibo->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('citerecibos.edit',$citerecibo->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $citerecibos->links() !!}
            </div>
        </div>
    </div>
@endsection
