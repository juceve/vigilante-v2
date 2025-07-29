<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('correlativo') }}
            {{ Form::text('correlativo', $citecotizacion->correlativo, ['class' => 'form-control' . ($errors->has('correlativo') ? ' is-invalid' : ''), 'placeholder' => 'Correlativo']) }}
            {!! $errors->first('correlativo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('gestion') }}
            {{ Form::text('gestion', $citecotizacion->gestion, ['class' => 'form-control' . ($errors->has('gestion') ? ' is-invalid' : ''), 'placeholder' => 'Gestion']) }}
            {!! $errors->first('gestion', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('cite') }}
            {{ Form::text('cite', $citecotizacion->cite, ['class' => 'form-control' . ($errors->has('cite') ? ' is-invalid' : ''), 'placeholder' => 'Cite']) }}
            {!! $errors->first('cite', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fecha') }}
            {{ Form::text('fecha', $citecotizacion->fecha, ['class' => 'form-control' . ($errors->has('fecha') ? ' is-invalid' : ''), 'placeholder' => 'Fecha']) }}
            {!! $errors->first('fecha', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fechaliteral') }}
            {{ Form::text('fechaliteral', $citecotizacion->fechaliteral, ['class' => 'form-control' . ($errors->has('fechaliteral') ? ' is-invalid' : ''), 'placeholder' => 'Fechaliteral']) }}
            {!! $errors->first('fechaliteral', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('destinatario') }}
            {{ Form::text('destinatario', $citecotizacion->destinatario, ['class' => 'form-control' . ($errors->has('destinatario') ? ' is-invalid' : ''), 'placeholder' => 'Destinatario']) }}
            {!! $errors->first('destinatario', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('cargo') }}
            {{ Form::text('cargo', $citecotizacion->cargo, ['class' => 'form-control' . ($errors->has('cargo') ? ' is-invalid' : ''), 'placeholder' => 'Cargo']) }}
            {!! $errors->first('cargo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('monto') }}
            {{ Form::text('monto', $citecotizacion->monto, ['class' => 'form-control' . ($errors->has('monto') ? ' is-invalid' : ''), 'placeholder' => 'Monto']) }}
            {!! $errors->first('monto', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('estado') }}
            {{ Form::text('estado', $citecotizacion->estado, ['class' => 'form-control' . ($errors->has('estado') ? ' is-invalid' : ''), 'placeholder' => 'Estado']) }}
            {!! $errors->first('estado', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>