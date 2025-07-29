<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('designacione_id') }}
            {{ Form::text('designacione_id', $asistencia->designacione_id, ['class' => 'form-control' . ($errors->has('designacione_id') ? ' is-invalid' : ''), 'placeholder' => 'Designacione Id']) }}
            {!! $errors->first('designacione_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fecha') }}
            {{ Form::text('fecha', $asistencia->fecha, ['class' => 'form-control' . ($errors->has('fecha') ? ' is-invalid' : ''), 'placeholder' => 'Fecha']) }}
            {!! $errors->first('fecha', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('ingreso') }}
            {{ Form::text('ingreso', $asistencia->ingreso, ['class' => 'form-control' . ($errors->has('ingreso') ? ' is-invalid' : ''), 'placeholder' => 'Ingreso']) }}
            {!! $errors->first('ingreso', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('salida') }}
            {{ Form::text('salida', $asistencia->salida, ['class' => 'form-control' . ($errors->has('salida') ? ' is-invalid' : ''), 'placeholder' => 'Salida']) }}
            {!! $errors->first('salida', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('latingreso') }}
            {{ Form::text('latingreso', $asistencia->latingreso, ['class' => 'form-control' . ($errors->has('latingreso') ? ' is-invalid' : ''), 'placeholder' => 'Latingreso']) }}
            {!! $errors->first('latingreso', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('lngingreso') }}
            {{ Form::text('lngingreso', $asistencia->lngingreso, ['class' => 'form-control' . ($errors->has('lngingreso') ? ' is-invalid' : ''), 'placeholder' => 'Lngingreso']) }}
            {!! $errors->first('lngingreso', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('latsalida') }}
            {{ Form::text('latsalida', $asistencia->latsalida, ['class' => 'form-control' . ($errors->has('latsalida') ? ' is-invalid' : ''), 'placeholder' => 'Latsalida']) }}
            {!! $errors->first('latsalida', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('lngsalida') }}
            {{ Form::text('lngsalida', $asistencia->lngsalida, ['class' => 'form-control' . ($errors->has('lngsalida') ? ' is-invalid' : ''), 'placeholder' => 'Lngsalida']) }}
            {!! $errors->first('lngsalida', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>