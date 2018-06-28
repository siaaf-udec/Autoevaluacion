<li><a><i class="fa fa-info-circle"></i> Fuentes primarias <span class="fa fa-chevron-down"></span></a>
    <ul class="nav child_menu">
        <li><a><i class="fa fa-file"></i>Gestionar Encuestas<span class="fa fa-chevron-down"></span> </a>
        <ul class="nav child_menu">
            <li class="sub_menu"><a href="{{ route('fuentesP.datosEncuestas.index') }}"><i class="fa fa-plus-square-o"></i>Datos generales sobre encuestas</a>
            </li>
            <li><a><i class="fa fa-file"></i>Construccion de Encuestas<span class="fa fa-chevron-down"></span> </a>
            <ul class="nav child_menu">
                <li><a href="{{ route('fuentesP.datosEspecificos.index') }}"><i class="fa fa-cog"></i>Datos especificos sobre encuestas</a>
                </li>
                <li><a href="{{ route('fuentesP.establecerPreguntas.index') }}"><i class="fa fa-check-square-o"></i>Establecer Preguntas</a>
                </li>
            </ul>
            <li><a href="#level2_2"><i class="fa fa-check-square-o"></i>Publicar encuestas</a>
            </li>
            <li><a href="#level2_2"><i class="fa fa-paste"></i>Importar encuestas</a>
            </li>
            </ul>
        </li>
        <li><a><i class="fa fa-question-circle"></i>Gestionar Preguntas<span class="fa fa-chevron-down"></span> </a>
        <ul class="nav child_menu">
            <li class="sub_menu"><a href="level2.html"><i class="fa fa-plus-square-o"></i>Crear pregunta</a>
            </li>
            <li><a href="#level2_1"><i class="fa fa-refresh"></i>Modificar pregunta</a>
            </li>
            <li><a href="#level2_2"><i class="fa fa-remove"></i>Eliminar pregunta</a>
            </li>
            <li><a href="#level2_2"><i class="fa fa-search"></i>Consultar preguntas</a>
            </li>
            </ul>
        </li>
        <li><a href ="{{ route('fuentesP.tipoRespuesta.index') }}" ><i class="fa fa-pencil-square-o"></i>Gestionar Respuestas </a>
        </li>
        <li><a><i class="fa fa-spinner"></i>Proceso de autoevaluacion<span class="fa fa-chevron-down"></span> </a>
        <ul class="nav child_menu">
            <li class="sub_menu"><a href="level2.html"><i class="fa fa-eye"></i>Ver encuesta</a>
            </li>
            <li><a href="#level2_1"><i class="fa fa-area-chart"></i>Generar informe</a>
            </li>
            <li><a href="#level2_2"><i class="fa fa-file-text"></i>Exportar informe</a>
            </li>
            </ul>
        </li>
    </ul>
</li>             