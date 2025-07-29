<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('correlativo') }}
            {{ Form::text('correlativo', $citecobro->correlativo, ['class' => 'form-control' . ($errors->has('correlativo') ? ' is-invalid' : ''), 'placeholder' => 'Correlativo']) }}
            {!! $errors->first('correlativo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('gestion') }}
            {{ Form::text('gestion', $citecobro->gestion, ['class' => 'form-control' . ($errors->has('gestion') ? ' is-invalid' : ''), 'placeholder' => 'Gestion']) }}
            {!! $errors->first('gestion', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('cite') }}
            {{ Form::text('cite', $citecobro->cite, ['class' => 'form-control' . ($errors->has('cite') ? ' is-invalid' : ''), 'placeholder' => 'Cite']) }}
            {!! $errors->first('cite', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fecha') }}
            {{ Form::text('fecha', $citecobro->fecha, ['class' => 'form-control' . ($errors->has('fecha') ? ' is-invalid' : ''), 'placeholder' => 'Fecha']) }}
            {!! $errors->first('fecha', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fechaliteral') }}
            {{ Form::text('fechaliteral', $citecobro->fechaliteral, ['class' => 'form-control' . ($errors->has('fechaliteral') ? ' is-invalid' : ''), 'placeholder' => 'Fechaliteral']) }}
            {!! $errors->first('fechaliteral', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('cliente') }}
            {{ Form::text('cliente', $citecobro->cliente, ['class' => 'form-control' . ($errors->has('cliente') ? ' is-invalid' : ''), 'placeholder' => 'Cliente']) }}
            {!! $errors->first('cliente', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('cliente_id') }}
            {{ Form::text('cliente_id', $citecobro->cliente_id, ['class' => 'form-control' . ($errors->has('cliente_id') ? ' is-invalid' : ''), 'placeholder' => 'Cliente Id']) }}
            {!! $errors->first('cliente_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('representante') }}
            {{ Form::text('representante', $citecobro->representante, ['class' => 'form-control' . ($errors->has('representante') ? ' is-invalid' : ''), 'placeholder' => 'Representante']) }}
            {!! $errors->first('representante', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('mescobro') }}
            {{ Form::text('mescobro', $citecobro->mescobro, ['class' => 'form-control' . ($errors->has('mescobro') ? ' is-invalid' : ''), 'placeholder' => 'Mescobro']) }}
            {!! $errors->first('mescobro', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('factura') }}
            {{ Form::text('factura', $citecobro->factura, ['class' => 'form-control' . ($errors->has('factura') ? ' is-invalid' : ''), 'placeholder' => 'Factura']) }}
            {!! $errors->first('factura', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('monto') }}
            {{ Form::text('monto', $citecobro->monto, ['class' => 'form-control' . ($errors->has('monto') ? ' is-invalid' : ''), 'placeholder' => 'Monto']) }}
            {!! $errors->first('monto', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>