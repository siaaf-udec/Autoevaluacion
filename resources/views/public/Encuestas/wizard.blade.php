{!! Form::label('PK_DAE_Id',isset($datos)? $datos->DAE_Titulo: 'Bienvenido') !!}
<div id="smartwizard">
    <ul class="hidden">
        <li><a href="#descripcion"></a></li>
        @foreach($preguntas as $pregunta)
        <li><a href="#{{$pregunta->preguntas->PK_PGT_Id }}"></a></li>
        @endforeach
    </ul>
    <div>
        <div id="descripcion" class="">
            {!! Form::label('PK_DAE_Id',isset($datos)? $datos->DAE_Descripcion: 'Su opinion es importante para nosotros. Por favor continue con el proceso de solucion de la encuesta') !!}
        </div>
        @foreach($preguntas as $pregunta)
            <div id="{{$pregunta->preguntas->PK_PGT_Id }}" class="">{{$pregunta->preguntas->PGT_Texto}} 
            @foreach($pregunta->preguntas->respuestas as $preguntaEncuesta) <br></br>
                {{ Form::radio($pregunta->preguntas->PK_PGT_Id, $preguntaEncuesta->PK_RPG_Id) }} {{ $preguntaEncuesta->RPG_Texto}}
            @endforeach
            @if ($loop->last)
            <div class="col-md-10 col-md-offset-9">
                {!! Form::submit('Finalizar', ['class' => 'btn btn-success']) !!}
            </div>  
            @endif
            </div>
        @endforeach
    </div>
</div>