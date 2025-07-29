<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('nombre') }}
            {{ Form::text('nombre', $visita->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
            {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('docidentidad') }}
            {{ Form::text('docidentidad', $visita->docidentidad, ['class' => 'form-control' . ($errors->has('docidentidad') ? ' is-invalid' : ''), 'placeholder' => 'Docidentidad']) }}
            {!! $errors->first('docidentidad', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('residente') }}
            {{ Form::text('residente', $visita->residente, ['class' => 'form-control' . ($errors->has('residente') ? ' is-invalid' : ''), 'placeholder' => 'Residente']) }}
            {!! $errors->first('residente', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('nrovivienda') }}
            {{ Form::text('nrovivienda', $visita->nrovivienda, ['class' => 'form-control' . ($errors->has('nrovivienda') ? ' is-invalid' : ''), 'placeholder' => 'Nrovivienda']) }}
            {!! $errors->first('nrovivienda', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('motivo_id') }}
            {{ Form::text('motivo_id', $visita->motivo_id, ['class' => 'form-control' . ($errors->has('motivo_id') ? ' is-invalid' : ''), 'placeholder' => 'Motivo Id']) }}
            {!! $errors->first('motivo_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('otros') }}
            {{ Form::text('otros', $visita->otros, ['class' => 'form-control' . ($errors->has('otros') ? ' is-invalid' : ''), 'placeholder' => 'Otros']) }}
            {!! $errors->first('otros', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('imgs') }}
            {{ Form::text('imgs', $visita->imgs, ['class' => 'form-control' . ($errors->has('imgs') ? ' is-invalid' : ''), 'placeholder' => 'Imgs']) }}
            {!! $errors->first('imgs', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('estado') }}
            {{ Form::text('estado', $visita->estado, ['class' => 'form-control' . ($errors->has('estado') ? ' is-invalid' : ''), 'placeholder' => 'Estado']) }}
            {!! $errors->first('estado', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>