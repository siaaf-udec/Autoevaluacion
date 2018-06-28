{!! Form::hidden('PK_TRP_Id', old('PK_TRP_Id'), ['id' => 'PK_TRP_Id']) !!}
<div class="item form-group">
    {!! Form::label('TRP_TotalPonderacion','Ponderacion Total', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('TRP_TotalPonderacion', old('TRP_TotalPonderacion'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
        'data-parsley-length'=>'[2, 60]', 'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('TRP_CantidadRespuestas','Cantidad Respuestas', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('TRP_CantidadRespuestas', old('TRP_CantidadRespuestas'),
        [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required'
        => 'required', 'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('TRP_Descripcion','Descripcion', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::textarea('TRP_Descripcion', old('TRP_Descripcion'),
        [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required'
        => 'required', 'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('PK_ESD_Id', 'Estado', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_ESD_Id', $estados, old('PK_ESD_Id'), ['class' => 'select2 form-control',
        'required' => '', 'id' => 'estado',
        'style' => 'width:100%'
        ])
        !!}
    </div>
</div>