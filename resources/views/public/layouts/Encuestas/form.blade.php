<div class="form-group">
{!! Form::label('PK_SDS_Id', 'Sede', ['class' => 'control-label col-md-4 col-sm-3 col-xs-12']) !!}
<div class="col-md-7 col-sm-6 col-xs-12">
{!! Form::select('PK_SDS_Id', $sedes, old('PK_SDS_Id', isset($proceso)? $proceso->programa->FK_PAC_Sede: ''),
[ 'placeholder' => 'Seleccione una sede', 'class' => 'select2 form-control', 'required' => '', 'id' => 'sede']) !!}
</div>
</div>

<div class="form-group">
{!! Form::label('PK_PAC_Id', 'Programa', ['class' => 'control-label col-md-4 col-sm-3 col-xs-12']) !!}
<div class="col-md-7 col-sm-6 col-xs-12">
{!! Form::select('PK_PAC_Id', isset($proceso)?$programas:[], old('PK_PAC_Id', 
isset($proceso)? $proceso->FK_PCS_Programa:
''), ['class' => 'select2 form-control','placeholder' => 'Seleccione un programa', 'required' => '', 
'id' => 'programa'])
!!}
</div>
    