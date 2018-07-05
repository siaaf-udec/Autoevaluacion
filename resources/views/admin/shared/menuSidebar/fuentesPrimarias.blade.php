<li><a><i class="fa fa-info-circle"></i> Fuentes primarias <span class="fa fa-chevron-down"></span></a>

    <ul class="nav child_menu">
        
        <li><a><i class="fa fa-file"></i>Gestionar Encuestas<span class="fa fa-chevron-down"></span> </a>
            
            <ul class="nav child_menu">
                @can('ACCEDER_DATOS')
                <li class="sub_menu"><a href="{{ route('fuentesP.datosEncuestas.index') }}"><i
                                class="fa fa-plus-square-o"></i>Datos generales sobre encuestas</a>
                </li>
                @endcan
                @can('ACCEDER_ENCUESTAS')
                <li class="sub_menu"><a href="{{ route('fuentesP.datosEspecificos.index') }}"><i
                                class="fa fa-plus-square-o"></i>Construccion de encuestas</a>
                </li>
                @endcan
                <li>

                <li><a href="#level2_2"><i class="fa fa-check-square-o"></i>Publicar encuestas</a>
                </li>

                <li><a href="#level2_2"><i class="fa fa-paste"></i>Importar encuestas</a>
                </li>
            </ul>
        </li>

        @can('ACCEDER_PREGUNTAS')
        <li><a href ="{{ route('fuentesP.preguntas.index') }}" ><i class="fa fa-question-circle"></i>Gestionar Preguntas</a>
        </li>
        @endcan

        @can('ACCEDER_TIPO_RESPUESTAS')
        <li><a href ="{{ route('fuentesP.tipoRespuesta.index') }}" ><i class="fa fa-pencil-square-o"></i>Gestionar Tipo de Respuestas </a>
        </li>
        @endcan

        <li><a><i class="fa fa-spinner"></i>Informes<span class="fa fa-chevron-down"></span> </a>
            <ul class="nav child_menu">
                <li><a href="#level2_1"><i class="fa fa-area-chart"></i>Generar informe</a>
                </li>
                <li><a href="#level2_2"><i class="fa fa-file-text"></i>Exportar informe</a>
                </li>
            </ul>
        </li>
    </ul>
</li>             