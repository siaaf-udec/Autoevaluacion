@include('autoevaluacion.FuentesPrimarias.Preguntas.form_general')

<div class="form-group">
    {!! Form::label('PK_RPG_Id', 'Respuestas', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
    @foreach($respuestas as $respuesta)
        <input type="text" id ="{{$respuesta->PK_RPG_Id}}" name = "{{$respuesta->PK_RPG_Id}}"
        value="{{$respuesta->RPG_Texto}}" required
        minLength="1" maxLength="5000" class = "form-control col-md-6 col-sm-6 col-xs-12" 
        pattern = "^[a-zA-Z ][a-zA-Z0-9-_\. ]{1,5000}$"/>
        <br></br>
    @endforeach
    </div>
</div>    



