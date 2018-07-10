<div class="item form-group">
    {!! Form::label('PK_LNM_Id', 'Lineamiento', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_LNM_Id', $lineamientos, old('PK_LNM_Id', isset($proceso)? $proceso->FK_PCS_Lineamiento: ''), [ 'placeholder' => 'Seleccione un lineamiento', 
        'class' => 'select2 form-control',
        'required' => '', 
        'id' => 'lineamiento'])
        !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('PK_FSS_Id', 'Fase', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_FSS_Id', isset($fases)?$fases:[], old('PK_FSS_Id', isset($proceso)? $proceso->FK_PCS_Fase: ''), [ 'placeholder' => 'Seleccione una fase', 
        'class' => 'select2 form-control',
        'required' => '', 
        'id' => 'fase'])
        !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PCS_Nombre','Nombre Proceso', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('PCS_Nombre', old('PCS_Nombre'), [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
        'data-parsley-length'=>'[5, 60]', 'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PCS_FechaInicio','Inicio', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('PCS_FechaInicio', 
        old('PCS_FechaInicio', isset($proceso)?(string)$proceso->PCS_FechaInicio->format('d/m/Y'):''), 
        [ 
            'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
            'required' => 'required',
            'id' => 'fecha_inicio'
        ] ) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PCS_FechaFin','Fin', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('PCS_FechaFin', 
        old('PCS_FechaFin', isset($proceso)?(string)$proceso->PCS_FechaFin->format('d/m/Y'):''), [ 
            'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
            'required' => 'required',
            'id' => 'fecha_fin'
        ] ) !!}
    </div>
</div>
