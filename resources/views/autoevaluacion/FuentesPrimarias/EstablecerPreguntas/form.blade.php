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