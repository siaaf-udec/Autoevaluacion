{!! Form::hidden('PK_PRT_Id', old('PK_PRT_Id'), ['id' => 'PK_PRT_Id']) !!}
<div class="item form-group">
    {!! Form::label('PRT_Titulo','Descripcion', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('PRT_Titulo', old('PRT_Titulo'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
        'data-parsley-length'=>'[1, 60]', 'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('PRT_Ponderacion','Ponderacion', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('PRT_Ponderacion', old('PRT_Ponderacion'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
        'data-parsley-length'=>'[1, 60]', 'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>