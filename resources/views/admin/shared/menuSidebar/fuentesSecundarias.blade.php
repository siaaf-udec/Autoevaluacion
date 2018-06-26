
<li><a><i class="fa fa-file-text-o"></i> Fuentes Secundarias <span class="fa fa-chevron-down"></span></a> 

<ul class="nav child_menu"> 
        <li><a href="{{ route('documental.dependencia.index') }}"><i class="fa fa-suitcase"></i>Dependencias</a> 
        </li> 
        <li><a href="{{ route('documental.indicadores_documentales.index')}}"><i class="fa fa-list"></i>Indicadores Documentales</a> 
        </li> 
        <li><a><i class="fa fa-file"></i>Documentos<span class="fa fa-chevron-down"></span> </a> 
        <ul class="nav child_menu"> 
            <li class="sub_menu"><a href="level2.html"><i class="fa fa-clipboard"></i>Documentos Autoevaluacion</a> 
            </li> 
            <li><a href="{{ route('documental.documentoinstitucional.index') }}"><i class="fa fa-file-text"></i>Documentos Institucionales</a> 
            </li> 
            <li><a href="{{ route('documental.grupodocumentos.index') }}"><i class="fa fa-briefcase"></i>Grupos de Documentos</a> 
            </li> 
            @can('ACCEDER_TIPO_DOCUMENTO')
            <li><a href="{{ route('documental.tipodocumento.index') }}"><i class="fa fa-cog"></i>Tipos de Documentos</a> 
            </li>
            @endcan 
            </ul> 
        </li> 
        <li><a><i class="fa fa-spinner"></i>Informes<span class="fa fa-chevron-down"></span> </a> 
        <ul class="nav child_menu"> 
            <li class="sub_menu"><a href="level2.html"><i class="fa fa-list-alt"></i>Informe parcial</a> 
            </li> 
            <li><a href="level2.html"><i class="fa fa-eye"></i>Informe Final</a> 
            </li> 
            <li><a href="#level2_1"><i class="fa fa-pie-chart"></i>Generar informe</a> 
            </li> 
            <li><a href="#level2_2"><i class="fa fa-file-text"></i>Exportar informe</a> 
            </li> 
            </ul> 
        </li> 
    </ul>