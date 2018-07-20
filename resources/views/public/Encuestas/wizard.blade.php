<font face="helvetica, arial">{!! Form::label('PK_DAE_Id',isset($datos)? $datos->DAE_Titulo: 'Bienvenido') !!}</font>
<div id="smartwizard">
    <ul class="hidden">
        <li><a href="#descripcion"></a></li>
        @foreach($preguntas as $pregunta)
        <li><a href="#{{$pregunta->preguntas->PK_PGT_Id }}"><br /></a></li>
        @endforeach
    </ul>
    <div>
        <div id="descripcion" class="">
        <font face="helvetica, arial">
                {!! Form::label('PK_DAE_Id',isset($datos)? $datos->DAE_Descripcion: 'Su opinion es importante para nosotros. Por favor continue con el proceso de solucion de la encuesta') !!}
            </font>
        </div>
        @foreach($preguntas as $pregunta)
            <div id="{{$pregunta->preguntas->PK_PGT_Id }}" class="">
            <font face="helvetica, arial"> <label>Pregunta Numero {{$loop->iteration}} de {{count($preguntas)}}:</label></font>
            <font face="helvetica, arial"> <label>{{$pregunta->preguntas->PGT_Texto}} </label> </font>
            @foreach($pregunta->preguntas->respuestas as $preguntaEncuesta)
            <font face="helvetica, arial"> 
                {{ Form::radio($pregunta->preguntas->PK_PGT_Id, $preguntaEncuesta->PK_RPG_Id,false,
                ['class' => 'radios','id'=>'preguntas']
                 ) }} {{ $preguntaEncuesta->RPG_Texto}}
            </font>
            </br>
                @endforeach
            @if ($loop->last)
            <div class="col-md-10 col-md-offset-9">
                {!! Form::submit('Finalizar', ['class' => 'btn btn-success', 'id' => 'finalizar']) !!}
            </div>  
            @endif
            </div>
        @endforeach
    </div>
</div>