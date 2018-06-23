<div class="form-group">
    {!! Form::label('LNM_Nombre','Nombre', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('LNM_Nombre', old('LNM_Nombre'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
        'data-parsley-length'=>'[5, 80]', 'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('LNM_Descripcion','Descripción', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::textarea('LNM_Descripcion', old('LNM_Descripcion'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
         'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>