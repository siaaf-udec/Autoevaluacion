<div class="item form-group">
{!! Form::label('ECT_FechaPublicacion','Fecha de Publicacion Año-Mes-Día', ['class'=>'control-label col-md-4 col-sm-3 col-xs-12']) !!}
    <div class="col-md-5 col-sm-9 col-xs-9">
    {!! Form::text('ECT_FechaPublicacion', old('ECT_FechaPublicacion'), [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12',
         'required' => 'required',
         'data-inputmask' => "'mask': '9999-99-99'",
        'data-parsley-trigger'=>"change" ] ) !!}
    <span class="fa fa-calendar form-control-feedback right" aria-hidden="true"></span>
    </div>
</div>

<div class="item form-group">
{!! Form::label('ECT_FechaFinalizacion','Fecha de Finalizacion Año-Mes-Día', ['class'=>'control-label col-md-4 col-sm-3 col-xs-12']) !!}
    <div class="col-md-5 col-sm-9 col-xs-9">
    {!! Form::text('ECT_FechaFinalizacion', old('ECT_FechaFinalizacion'), [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12',
         'required' => 'required',
         'data-inputmask' => "'mask': '9999-99-99'",
        'data-parsley-trigger'=>"change" ] ) !!}
    <span class="fa fa-calendar form-control-feedback right" aria-hidden="true"></span>
    </div>
</div>

<div class="item form-group">
{!! Form::label('FK_ECT_Estado','Estado', [ 'class'=>'control-label col-md-4 col-sm-3 col-xs-12']) !!}
        <div class="col-md-5 col-sm-9 col-xs-9">
        {!! Form::select('FK_ECT_Estado',$estados, old('FK_ECT_Estado'), [
            'placeholder' => 'Seleccione un estado',
            'class' => 'select2 form-control',
            'id' => 'estado', 
            'required' => 'required' ]) !!}
        </div>
</div>


<div class="item form-group">
    {!! Form::label('PK_SDS_Id', 'Sedes', ['class' => 'control-label col-md-4 col-sm-3 col-xs-12']) !!}
    <div class="col-md-5 col-sm-9 col-xs-9">
        {!! Form::select('PK_SDS_Id', $sedes, old('PK_SDS_Id', isset($encuesta)? 
        $encuesta->proceso->sede()->pluck('PK_SDS_Id', 'SDS_Nombre'): ''), [
            'placeholder' => 'Seleccione una sede',
            'class' => 'select2 form-control',
            'id' => 'sede',
            'required' => 'required']) !!}
    </div>
</div>

<div class="item form-group">
    {!! Form::label('FK_ECT_Proceso', 'Proceso', ['class' => 'control-label col-md-4 col-sm-3 col-xs-12']) !!}
    <div class="col-md-5 col-sm-9 col-xs-9">
        {!! Form::select('FK_ECT_Proceso', isset($procesos)?$procesos:[], old('FK_ECT_Proceso', isset($encuesta)? 
        $encuesta->proceso()->pluck('PK_PCS_Id', 'PCS_Nombre'): ''), ['class' => 'select2 form-control',
        'placeholder' => 'Seleccione un proceso',
        'id' => 'proceso',
        'required' => 'required']) !!}
    </div>
</div>

<div class="item form-group">
    {!! Form::label('grupo','Grupo de Interes', [ 'class'=>'control-label col-md-4 col-sm-3 col-xs-12']) !!}
    <div class="col-md-5 col-sm-9 col-xs-9">
        {!! Form::select('PK_GIT_Id', $grupos, old('PK_GIT_Id'), [
            'class' => 'select2_user form-control',
            'placeholder' => 'Seleccione un grupo de interes',
            'id' => 'grupo',
            'required' => 'required']) !!}
    </div>
</div>

<div class="item form-group">
    {!! Form::label('FK_ECT_DatosEncuesta', 'Titulo de la Encuesta', ['class' => 'control-label col-md-4 col-sm-3 col-xs-12']) !!}
    <div class="col-md-5 col-sm-9 col-xs-9">
        {!! Form::select('FK_ECT_DatosEncuesta', isset($descripcion)?$descripcion:[], old('FK_ECT_DatosEncuesta', isset($encuesta)? 
        $encuesta->datos()->pluck('PK_DAE_Id', 'DAE_Titulo'): ''), ['class' => 'select2 form-control',
        'placeholder' => 'Seleccione un titutlo',
        'id' => 'descripcion',
        'required' => 'required']) !!}
    </div>
</div>
