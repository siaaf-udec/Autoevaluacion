{!! Form::label('PK_DAE_Id',$datos->DAE_Titulo) !!}
<div id="smartwizard">
    <ul class="hidden">
        <li><a href="#descripcion"></a></li>
        @foreach($preguntas as $pregunta)
        <li><a href="#{{$pregunta->preguntas->PK_PGT_Id }}"></a></li>
        @endforeach
    </ul>
    <div>
        <div id="descripcion" class="">
            {!! Form::label('PK_DAE_Id',$datos->DAE_Descripcion) !!}
        </div>
        @foreach($preguntas as $pregunta)
            <div id="{{$pregunta->preguntas->PK_PGT_Id }}" class="">{{$pregunta->preguntas->PGT_Texto}} 
            <br></br>
            @foreach($pregunta->preguntas->respuestas as $preguntaEncuesta)
                {{ Form::radio('respuestas[]', $preguntaEncuesta->PK_RPG_Id, true) }} {{ $preguntaEncuesta->RPG_Texto}}
            <br></br>
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