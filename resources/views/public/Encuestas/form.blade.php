<div class="form-group">
{!! Form::label('PK_GIT_Id', 'Grupo de Interes', ['class' => 'control-label col-md-5 col-sm-3 col-xs-12']) !!}
<div class="col-md-6 col-sm-8 col-xs-12">
{!! Form::select('PK_GIT_Id', $grupos,old('PK_GIT_Id'),
[ 'placeholder' => 'Seleccione una grupo de interes', 
'class' => 'select2 form-control', 
'required' => '', 
'id' => 'grupos']) !!}
</div>
</div>