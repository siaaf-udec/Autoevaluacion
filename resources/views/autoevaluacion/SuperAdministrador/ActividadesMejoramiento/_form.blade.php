<div class="item form-group">
    {!! Form::label('PK_LNM_Id', 'Lineamiento', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_LNM_Id', $lineamientos, old('PK_LNM_Id', isset($pregunta)? 
        $pregunta->caracteristica->factor->lineamiento()->pluck('PK_LNM_Id', 'LNM_Nombre'): ''), [
            'placeholder' => 'Seleccione un lineamiento',
            'class' => 'select2 form-control',
            'id' => 'lineamiento']) !!}
    </div>
</div>

<div class="item form-group">
    {!! Form::label('PK_FCT_Id', 'Factor', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_FCT_Id', isset($factores)?$factores:[], old('PK_FCT_Id', isset($pregunta)? 
        $pregunta->caracteristica->factor()->pluck('PK_FCT_Id', 'FCT_Nombre'): ''), ['class' => 'select2 form-control',
        'placeholder' => 'Seleccione un factor',
        'required' => 'required',
        'id' => 'factor']) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('PK_CRT_Id', 'Caracteristica', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_CRT_Id', isset($caracteristicas)?$caracteristicas:[],
         old('PK_CRT_Id', isset($pregunta)? $pregunta->FK_ASP_Caracteristica
        : ''), ['class' => 'select2 form-control', 
        'required' => 'required',
        'id' => 'caracteristica']) !!}
    </div>
</div>