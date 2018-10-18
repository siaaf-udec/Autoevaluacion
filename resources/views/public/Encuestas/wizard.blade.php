<input type="hidden" id="focus" autofocus>
<font face="helvetica, arial">{!! Form::label('PK_DAE_Id',isset($datos)? $datos->DAE_Titulo: 'Bienvenido') !!}</font>
<div id="smartwizard">
    <ul class="hidden">
        <li><a href="#descripcion"></a></li>
        @foreach($preguntas as $pregunta)
            <li><a href="#{{$pregunta->preguntas->PK_PGT_Id }}"><br/></a></li>
        @endforeach
    </ul>
    <div>
        <div id="descripcion" class="">
            <font face="helvetica, arial">
                {!! Form::label('PK_DAE_Id',isset($datos)? $datos->DAE_Descripcion: 'Su opinion es importante para nosotros. Por favor continue con el proceso de solucion de la encuesta') !!}
                <br/>
                <label>INSTRUCCIONES: </label><br/>
                {!! Form::label('Instricciones','Para cada una de las preguntas, seleccione la opcion que mejor exprese su opinion sobre el tema que trate. Una vez seleccionada una respuesta, se habilitará la opción de continuar para finalizar el proceso de solución de la encuesta. ') !!}
            </font>
        </div>
        @foreach($preguntas as $pregunta)
            <div id="{{$pregunta->preguntas->PK_PGT_Id }}">
                <font face="helvetica, arial"> <label>Pregunta Número {{$loop->iteration}} de {{count($preguntas)}}
                        :</label></font>
                <font face="helvetica, arial"> <label><p class="text-justify">{{$pregunta->preguntas->PGT_Texto}}</p>
                    </label> </font><br/>
                @foreach($pregunta->preguntas->respuestas as $preguntaEncuesta)
                    <font face="helvetica, arial">
                        <div class="radio">
                            <label>
                                {{ Form::radio($pregunta->preguntas->PK_PGT_Id, $preguntaEncuesta->PK_RPG_Id,false,
                                ['class' => 'radios','id'=>'preguntas',
                                'autocomplete' => 'on']
                                 ) }}<p class="text-justify"> {{ $preguntaEncuesta->RPG_Texto}}</p>
                            </label>
                        </div>
                    </font>
                @endforeach
                @if ($loop->last)
                    <div class="col-md-19 col-md-offset-9">
                        {!! Form::submit('Finalizar', ['class' => 'btn btn-success', 'id' => 'finalizar']) !!}
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>