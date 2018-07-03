<div class="form-group">
    {!! Form::label('PK_ESD_Id', 'Estado', ['class' => 'control-label col-md-4 col-sm-3 col-xs-12']) !!}
    <div class="col-md-5 col-sm-9 col-xs-9">
        {!! Form::select('PK_ESD_Id', $estados, old('PK_ESD_Id'), ['class' => 'select2 form-control',
        'required' => '', 'id' => 'estado',
        'style' => 'width:100%'
        ])
        !!}
    </div>
</div>

<div class="item form-group">
    {!! Form::label('grupo','Grupo de Interes', [ 'class'=>'control-label col-md-4 col-sm-3 col-xs-12']) !!}
    <div class="col-md-5 col-sm-9 col-xs-9">
        {!! Form::select('PK_GIT_Id', $grupos, old('PK_GIT_Id', isset($encuesta)?
        $encuesta->datos->grupos()->pluck('PK_GIT_Id', 'GIT_Nombre'): '' ), [
            'class' => 'select2_user form-control',
            'placeholder' => 'Seleccione un grupo de interes',
            'id' => 'grupo',
            'required' => 'required']) !!}
    </div>
</div>

<div class="item form-group">
    {!! Form::label('PK_DAE_Id', 'Titulo de la Encuesta', ['class' => 'control-label col-md-4 col-sm-3 col-xs-12']) !!}
    <div class="col-md-5 col-sm-9 col-xs-9">
        {!! Form::select('PK_DAE_Id', isset($descripcion)?$descripcion:[], old('PK_DAE_Id', isset($encuesta)? 
        $encuesta->datos()->pluck('PK_DAE_Id', 'DAE_Titulo'): ''), ['class' => 'select2 form-control',
        'placeholder' => 'Seleccione un titutlo',
        'id' => 'descripcion',
        'required' => 'required']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('ECT_FechaPublicacion','Fecha Publicacion', ['class'=>'control-label col-md-4 col-sm-3 col-xs-12']) !!}
    <div class="col-md-5 col-sm-9 col-xs-9">
        {!! Form::text('ECT_FechaPublicacion',
        old('ECT_FechaPublicacion', isset($encuesta)?(string)$encuesta->ECT_FechaPublicacion->format('d/m/Y'):''), 
        [ 
            'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
            'required' => 'required',
            'id' => 'fecha_inicio'
        ] ) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('ECT_FechaFinalizacion','Fecha Finalizacion', ['class'=>'control-label col-md-4 col-sm-3 col-xs-12']) !!}
    <div class="col-md-5 col-sm-9 col-xs-9">
        {!! Form::text('ECT_FechaFinalizacion', 
        old('ECT_FechaFinalizacion',isset($encuesta)?(string)$encuesta->ECT_FechaFinalizacion->format('d/m/Y'):''),
        [ 
            'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
            'required' => 'required',
            'id' => 'fecha_fin'
        ] ) !!}
    </div>
</div>




