<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('correlativo') }}
            {{ Form::text('correlativo', $citememorandum->correlativo, ['class' => 'form-control' . ($errors->has('correlativo') ? ' is-invalid' : ''), 'placeholder' => 'Correlativo']) }}
            {!! $errors->first('correlativo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('gestion') }}
            {{ Form::text('gestion', $citememorandum->gestion, ['class' => 'form-control' . ($errors->has('gestion') ? ' is-invalid' : ''), 'placeholder' => 'Gestion']) }}
            {!! $errors->first('gestion', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('cite') }}
            {{ Form::text('cite', $citememorandum->cite, ['class' => 'form-control' . ($errors->has('cite') ? ' is-invalid' : ''), 'placeholder' => 'Cite']) }}
            {!! $errors->first('cite', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fecha') }}
            {{ Form::text('fecha', $citememorandum->fecha, ['class' => 'form-control' . ($errors->has('fecha') ? ' is-invalid' : ''), 'placeholder' => 'Fecha']) }}
            {!! $errors->first('fecha', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fechaliteral') }}
            {{ Form::text('fechaliteral', $citememorandum->fechaliteral, ['class' => 'form-control' . ($errors->has('fechaliteral') ? ' is-invalid' : ''), 'placeholder' => 'Fechaliteral']) }}
            {!! $errors->first('fechaliteral', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('empleado') }}
            {{ Form::text('empleado', $citememorandum->empleado, ['class' => 'form-control' . ($errors->has('empleado') ? ' is-invalid' : ''), 'placeholder' => 'Empleado']) }}
            {!! $errors->first('empleado', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('empleado_id') }}
            {{ Form::text('empleado_id', $citememorandum->empleado_id, ['class' => 'form-control' . ($errors->has('empleado_id') ? ' is-invalid' : ''), 'placeholder' => 'Empleado Id']) }}
            {!! $errors->first('empleado_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('cuerpo') }}
            {{ Form::text('cuerpo', $citememorandum->cuerpo, ['class' => 'form-control' . ($errors->has('cuerpo') ? ' is-invalid' : ''), 'placeholder' => 'Cuerpo']) }}
            {!! $errors->first('cuerpo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('estado') }}
            {{ Form::text('estado', $citememorandum->estado, ['class' => 'form-control' . ($errors->has('estado') ? ' is-invalid' : ''), 'placeholder' => 'Estado']) }}
            {!! $errors->first('estado', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>