<div class="box box-info padding-1">
    <div class="box-body">
        <div class="row">
            <div class="col col-12 col-md-6">
                <div class="form-group">
                    {{ Form::label('nombre') }}
                    {{ Form::text('nombre', $cliente->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? '
                    is-invalid' : ''), 'placeholder' => 'Nombre']) }}
                    {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
            <div class="col col-12 col-md-3">
                <div class="form-group{{ $errors->has('tipodocumento_id') ? ' has-error' : '' }}">
                    {!! Form::label('tipodocumento_id', 'Tipo Documento') !!}
                    {!! Form::select('tipodocumento_id', $tipodocs, $cliente->tipodocumento_id, [
                    'id' => 'tipodocumento_id',
                    'class' => 'form-control',
                    'required' => 'required',
                    'placeholder' => 'Seleccione una opción',
                    ]) !!}
                    <small class="text-danger">{{ $errors->first('tipodocumento_id') }}</small>
                </div>
            </div>
            <div class="col col-12 col-md-3">
                <div class="form-group">
                    {{ Form::label('Nro. Doc.') }}
                    {{ Form::text('nrodocumento', $cliente->nrodocumento, ['class' => 'form-control' .
                    ($errors->has('nrodocumento') ? ' is-invalid' : ''), 'placeholder' => 'Nrodocumento']) }}
                    {!! $errors->first('nrodocumento', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
            <div class="col col-12 col-md-6">
                <div class="form-group">
                    {{ Form::label('dirección') }}
                    {{ Form::text('direccion', $cliente->direccion, ['class' => 'form-control' .
                    ($errors->has('direccion') ? ' is-invalid' : ''), 'placeholder' => 'Direccion']) }}
                    {!! $errors->first('direccion', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
            <div class="col col-12 col-md-3">
                <div class="form-group">
                    {{ Form::label('U.V.') }}
                    {{ Form::text('uv', $cliente->uv, ['class' => 'form-control' . ($errors->has('uv') ? ' is-invalid' :
                    ''), 'placeholder' => 'Uv']) }}
                    {!! $errors->first('uv', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
            <div class="col col-12 col-md-3">
                <div class="form-group">
                    {{ Form::label('manzano') }}
                    {{ Form::text('manzano', $cliente->manzano, ['class' => 'form-control' . ($errors->has('manzano') ?
                    ' is-invalid' : ''), 'placeholder' => 'Manzano']) }}
                    {!! $errors->first('manzano', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
            <div class="col col-12 col-md-6 d-none">
                <div class="form-group">
                    {{ Form::label('latitud') }}
                    {{ Form::text('latitud', $cliente->latitud, ['class' => 'form-control' . ($errors->has('latitud') ?
                    ' is-invalid' : ''), 'placeholder' => 'Latitud', 'id' => 'latitud']) }}
                    {!! $errors->first('latitud', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
            <div class="col col-12 col-md-6 d-none">
                <div class="form-group">
                    {{ Form::label('longitud') }}
                    {{ Form::text('longitud', $cliente->longitud, ['class' => 'form-control' . ($errors->has('longitud')
                    ? ' is-invalid' : ''), 'placeholder' => 'Longitud', 'id' => 'longitud']) }}
                    {!! $errors->first('longitud', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
            <div class="col col-12 col-md-6">
                <div class="form-group">
                    {{ Form::label('Persona Contacto') }}
                    {{ Form::text('personacontacto', $cliente->personacontacto, ['class' => 'form-control' .
                    ($errors->has('personacontacto') ? ' is-invalid' : ''), 'placeholder' => 'Personacontacto']) }}
                    {!! $errors->first('personacontacto', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
            <div class="col col-12 col-md-6">
                <div class="form-group">
                    {{ Form::label('Teléfono Contacto') }}
                    {{ Form::text('telefonocontacto', $cliente->telefonocontacto, ['class' => 'form-control' .
                    ($errors->has('telefonocontacto') ? ' is-invalid' : ''), 'placeholder' => 'Telefonocontacto']) }}
                    {!! $errors->first('telefonocontacto', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
            <div class="col col-12 col-md-6">
                <div class="form-group{{ $errors->has('oficina_id') ? ' has-error' : '' }}">
                    {!! Form::label('oficina_id', 'Oficina vinculada') !!}
                    {!! Form::select('oficina_id', $oficinas, $cliente->oficina_id, [
                    'id' => 'oficina_id',
                    'class' => 'form-control',
                    'required' => 'required',
                    'placeholder' => 'Seleccione una opción',
                    ]) !!}
                    <small class="text-danger">{{ $errors->first('oficina_id') }}</small>
                </div>
            </div>

            <div class="col col-12 col-md-6">
                <div class="form-group">
                    {{ Form::label('observaciones') }}
                    {{ Form::text('observaciones', $cliente->observaciones, ['class' => 'form-control' .
                    ($errors->has('observaciones') ? ' is-invalid' : ''), 'placeholder' => 'Observaciones']) }}
                    {!! $errors->first('observaciones', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
            <div class="col col-12 col-md-6">
                <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                    {!! Form::label('status', 'Estado') !!}
                    {!! Form::select('status', ['1' => 'Activo', '0' => 'Inactivo'], $cliente->status, [
                    'id' => 'status',
                    'class' => 'form-control',
                    'required' => 'required',
                    'placeholder' => 'Seleccione una opcion',
                    ]) !!}
                    <small class="text-danger">{{ $errors->first('status') }}</small>
                </div>
            </div>
            <div class="col col-12 mb-2">
                <label for="mapa">Ubicación del Domicilio</label>
                <div id="mi_mapa" style="width: 100%; height: 500px;"></div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row mt-3">
        <div class="col-12 col-md-6">
            <div class="box-footer mt20">
                <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>
@section('plugins.OpenStreetMap', true)
@section('js')
<script>
    let map = L.map('mi_mapa').setView([{{ $cliente->latitud?$cliente->latitud:-17.7817999 }}, {{ $cliente->longitud?$cliente->longitud:-63.1825485 }}], 17)

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy;'
        }).addTo(map);


        var myIcon = L.icon({
            iconUrl: "{{ asset('images/punt.png') }}",
            iconSize: [35, 35],
            iconAnchor: [35, 35],
            popupAnchor: [-15, -30],
        });

        var marker = L.marker([{{ $cliente->latitud?$cliente->latitud:-17.7817999 }}, {{ $cliente->longitud?$cliente->longitud:-63.1825485 }}], {
            "draggable": true
        }).addTo(map);

        marker.on('dragend', function(event) {
            var position = marker.getLatLng();
            marker.setLatLng(position, {
                draggable: 'true'
            }).bindPopup(position).update();
            $("#latitud").val(position.lat);
            $("#longitud").val(position.lng).keyup();
        });
</script>
@endsection