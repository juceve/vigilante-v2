<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('codigo') }}
            {{ Form::text('codigo', $rrhhtipocontrato->codigo, ['class' => 'form-control' . ($errors->has('codigo') ? ' is-invalid' : ''), 'placeholder' => 'Codigo']) }}
            {!! $errors->first('codigo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('nombre') }}
            {{ Form::text('nombre', $rrhhtipocontrato->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
            {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('descripcion') }}
            {{ Form::text('descripcion', $rrhhtipocontrato->descripcion, ['class' => 'form-control' . ($errors->has('descripcion') ? ' is-invalid' : ''), 'placeholder' => 'Descripcion']) }}
            {!! $errors->first('descripcion', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('cantidad_dias') }}
            {{ Form::number('cantidad_dias', $rrhhtipocontrato->cantidad_dias, ['class' => 'form-control' . ($errors->has('cantidad_dias') ? ' is-invalid' : ''), 'placeholder' => '0']) }}
            {!! $errors->first('cantidad_dias', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('horas_dia') }}
            {{ Form::number('horas_dia', $rrhhtipocontrato->horas_dia, ['class' => 'form-control' . ($errors->has('horas_dia') ? ' is-invalid' : ''), 'placeholder' => '0']) }}
            {!! $errors->first('horas_dia', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('sueldo_referencial') }}
            {{ Form::number('sueldo_referencial', $rrhhtipocontrato->sueldo_referencial, ['class' => 'form-control' . ($errors->has('sueldo_referencial') ? ' is-invalid' : ''), 'placeholder' => '0.00', 'step' => 'any']) }}
            {!! $errors->first('sueldo_referencial', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('activo') }}            
            {!! Form::select('activo', ['1'=>'SI','0'=>'NO'], $rrhhtipocontrato->activo, ['class' => 'form-control'. ($errors->has('sueldo_referencial') ? ' is-invalid' : '')]) !!}
            {!! $errors->first('activo', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary btn-block col-12 col-md-4">Guardar <i class="fas fa-save"></i></button>
    </div>

 
</div>