
<div class="item form-group">
    {!! Form::label('PK_FCT_Id', 'Factor', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_FCT_Id', isset($factores)?$factores:[], old('PK_FCT_Id', isset($preguntas)? 
        $preguntas->caracteristica->factor()->pluck('PK_FCT_Id', 'FCT_Nombre'): ''), ['class' => 'select2 form-control',
        'placeholder' => 'Seleccione un factor',
        'id' => 'factor']) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('PK_CRT_Id', 'Caracteristica', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_CRT_Id', isset($caracteristicas)?$caracteristicas:[],
         old('PK_CRT_Id', isset($preguntas)? $preguntas->FK_PGT_Caracteristica
        : ''), ['class' => 'select2 form-control','placeholder' => 'Seleccione una característica', 
        'required' => '',
        'id' => 'caracteristica']) !!}
    </div>
</div>

<div class="item form-group">
    {!! Form::label('PK_PGT_Id', 'Pregunta', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_PGT_Id', isset($preguntas)?$preguntas:[],
         old('PK_PGT_Id', isset($preguntas)? $preguntas->PGT_Texto
        : ''), ['class' => 'select2 form-control','placeholder' => 'Seleccione una pregunta', 
        'required' => '',
        'id' => 'preguntas']) !!}
    </div>
</div>

<div class="item form-group">
{!! Form::label('PK_GIT_Id', 'Grupos de Interes', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
<div class="col-md-6 col-sm-6 col-xs-12">
        @foreach($grupos as $grupo)
        {!! Form::checkbox('check[]',$grupo->PK_GIT_Id )!!}{{$grupo->GIT_Nombre}}<br>
@endforeach
</div>
</div>

<div class="form-group">
    {!! Form::hidden('PK_ECT_Id', Session::get('id_encuesta')) !!}
</div>