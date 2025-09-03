<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('residencia_id') }}
            {{ Form::text('residencia_id', $paseingreso->residencia_id, ['class' => 'form-control' . ($errors->has('residencia_id') ? ' is-invalid' : ''), 'placeholder' => 'Residencia Id']) }}
            {!! $errors->first('residencia_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('nombre') }}
            {{ Form::text('nombre', $paseingreso->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
            {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('cedula') }}
            {{ Form::text('cedula', $paseingreso->cedula, ['class' => 'form-control' . ($errors->has('cedula') ? ' is-invalid' : ''), 'placeholder' => 'Cedula']) }}
            {!! $errors->first('cedula', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fecha_inicio') }}
            {{ Form::text('fecha_inicio', $paseingreso->fecha_inicio, ['class' => 'form-control' . ($errors->has('fecha_inicio') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Inicio']) }}
            {!! $errors->first('fecha_inicio', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fecha_fin') }}
            {{ Form::text('fecha_fin', $paseingreso->fecha_fin, ['class' => 'form-control' . ($errors->has('fecha_fin') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Fin']) }}
            {!! $errors->first('fecha_fin', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('tipopase_id') }}
            {{ Form::text('tipopase_id', $paseingreso->tipopase_id, ['class' => 'form-control' . ($errors->has('tipopase_id') ? ' is-invalid' : ''), 'placeholder' => 'Tipopase Id']) }}
            {!! $errors->first('tipopase_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('detalles') }}
            {{ Form::text('detalles', $paseingreso->detalles, ['class' => 'form-control' . ($errors->has('detalles') ? ' is-invalid' : ''), 'placeholder' => 'Detalles']) }}
            {!! $errors->first('detalles', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('url_foto') }}
            {{ Form::text('url_foto', $paseingreso->url_foto, ['class' => 'form-control' . ($errors->has('url_foto') ? ' is-invalid' : ''), 'placeholder' => 'Url Foto']) }}
            {!! $errors->first('url_foto', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>