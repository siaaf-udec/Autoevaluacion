{!! Form::hidden('PK_AMB_Id', old('PK_AMB_Id'), ['id' => 'PK_AMB_Id']) !!}
<div class="item form-group">
    {!! Form::label('AMB_Nombre','Nombre', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('AMB_Nombre', old('AMB_Nombre'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
        'required' => 'required', 
        'data-parsley-pattern' => '^[a-zA-Z ][a-zA-Z0-9-_\. ]{1,500}$',
        'data-parsley-pattern-message' => 'Por favor escriba solo letras',
        'data-parsley-length'=>'[7, 60]',
        'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>