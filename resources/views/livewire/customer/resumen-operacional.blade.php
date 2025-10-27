<div>
    <div class="card">
        <div class="card-header bg-success text-white">Resumen Operacional</div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-5">
                    <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Desde</span>
                        </div>
                        <input type="date" class="form-control" wire:model='fechaInicio' aria-label="fechaInicio">
                    </div>
                </div>
                <div class="col-12 col-md-5">
                    <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Hasta</span>
                        </div>
                        <input type="date" class="form-control" wire:model='fechaFin' aria-label="fechaFin">
                    </div>
                </div>
            </div>
            <table class="table table-bordered" style="font-size: 12px;">
                <thead class="table-success">
                    <tr class="text-center">

                        <th>RONDAS EJECUTADAS</th>
                        <th>REG. VISITAS</th>
                        <th>REG. PASES QR</th>
                        <th>PANICOS REPORTADOS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($resultados as $item)
                    <tr class="text-center">
                        <td>{{$item['rondas']}}</td>
                        <td>{{$item['visitas']}}</td>
                        <td>{{$item['flujopases']}}</td>
                        <td>{{$item['panicos']}}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">No existen datos disponibles</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>