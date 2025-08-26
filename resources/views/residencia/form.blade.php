<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('cliente_id') }}
            {{ Form::text('cliente_id', $residencia->cliente_id, ['class' => 'form-control' . ($errors->has('cliente_id') ? ' is-invalid' : ''), 'placeholder' => 'Cliente Id']) }}
            {!! $errors->first('cliente_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('propietario_id') }}
            {{ Form::text('propietario_id', $residencia->propietario_id, ['class' => 'form-control' . ($errors->has('propietario_id') ? ' is-invalid' : ''), 'placeholder' => 'Propietario Id']) }}
            {!! $errors->first('propietario_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('cedula_propietario') }}
            {{ Form::text('cedula_propietario', $residencia->cedula_propietario, ['class' => 'form-control' . ($errors->has('cedula_propietario') ? ' is-invalid' : ''), 'placeholder' => 'Cedula Propietario']) }}
            {!! $errors->first('cedula_propietario', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('numeropuerta') }}
            {{ Form::text('numeropuerta', $residencia->numeropuerta, ['class' => 'form-control' . ($errors->has('numeropuerta') ? ' is-invalid' : ''), 'placeholder' => 'Numeropuerta']) }}
            {!! $errors->first('numeropuerta', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('piso') }}
            {{ Form::text('piso', $residencia->piso, ['class' => 'form-control' . ($errors->has('piso') ? ' is-invalid' : ''), 'placeholder' => 'Piso']) }}
            {!! $errors->first('piso', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('calle') }}
            {{ Form::text('calle', $residencia->calle, ['class' => 'form-control' . ($errors->has('calle') ? ' is-invalid' : ''), 'placeholder' => 'Calle']) }}
            {!! $errors->first('calle', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('nrolote') }}
            {{ Form::text('nrolote', $residencia->nrolote, ['class' => 'form-control' . ($errors->has('nrolote') ? ' is-invalid' : ''), 'placeholder' => 'Nrolote']) }}
            {!! $errors->first('nrolote', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('manzano') }}
            {{ Form::text('manzano', $residencia->manzano, ['class' => 'form-control' . ($errors->has('manzano') ? ' is-invalid' : ''), 'placeholder' => 'Manzano']) }}
            {!! $errors->first('manzano', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('notas') }}
            {{ Form::text('notas', $residencia->notas, ['class' => 'form-control' . ($errors->has('notas') ? ' is-invalid' : ''), 'placeholder' => 'Notas']) }}
            {!! $errors->first('notas', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('estado') }}
            {{ Form::text('estado', $residencia->estado, ['class' => 'form-control' . ($errors->has('estado') ? ' is-invalid' : ''), 'placeholder' => 'Estado']) }}
            {!! $errors->first('estado', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>