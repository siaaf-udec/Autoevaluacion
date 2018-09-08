{!! Form::hidden('PK_AMB_Id', old('PK_AMB_Id'), ['id' => 'PK_AMB_Id']) !!}
<div class="form-group">
    {!! Form::label('AMB_Nombre','Ambito', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('AMB_Nombre', old('AMB_Nombre'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
         'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>

