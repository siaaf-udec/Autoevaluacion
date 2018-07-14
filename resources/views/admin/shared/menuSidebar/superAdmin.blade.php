<li><a href="#"><i class="fa fa-users">
        </i> Usuarios<span class="fa fa-chevron-down"></span></a>
    <ul class="nav child_menu">
        @can('ACCEDER_USUARIOS')
            <li><a href="{{ route('admin.usuarios.index') }}"><i class="fa fa-user">
                    </i>Administrar usuarios</a>
            </li>
        @endcan
        @can('ACCEDER_ROLES')
            <li><a href="{{ route('admin.roles.index') }}"><i class="fa fa-gavel">
                    </i>Roles</a>
            </li>
        @endcan
        @can('ACCEDER_PERMISOS')
            <li><a href="{{ route('admin.permisos.index') }}"><i class="fa fa-unlock">
                    </i>Permisos</a>
            </li>
        @endcan
    </ul>
</li>
<li><a><i class="fa fa-diamond"></i> Super administrador <span class="fa fa-chevron-down"></span></a>
    <ul class="nav child_menu">
        @can('ACCEDER_SEDES')
            <li>
                <a href="{{ route('admin.sedes.index')}}"><i class="fa fa-university"></i> Sedes</a>
            </li>
        @endcan
        @can('ACCEDER_FACULTADES')
            <li>
                <a href="{{ route('admin.facultades.index')}}"><i class="fa fa-university"></i> Facultades</a>
            </li>
        @endcan
        @can('ACCEDER_PROGRAMAS_ACADEMICOS')
            <li>
                <a href="{{ route('admin.programas_academicos.index')}}"><i class="fa fa-university"></i> Programas
                    Académicos</a>
            </li>
        @endcan
        @can('ACCEDER_PROCESOS_INSTITUCIONALES')
        <li>
            <a href="{{ route('admin.procesos_institucionales.index')}}"><i class="fa fa-university"></i> Procesos
                            institucionales</a>
        </li>
        @endcan
        @can('ACCEDER_PROCESOS_PROGRAMAS')
            <li>
                <a href="{{ route('admin.procesos_programas.index')}}"><i class="fa fa-university"></i> Procesos
                    programas</a>
            </li>
        @endcan
        @can('ACCEDER_GRUPOS_INTERES')
            <li>
                <a href="{{ route('admin.grupos_interes.index')}}"><i class="fa fa-university"></i> Grupos
                    de Interes</a>
            </li>
        @endcan
        @can('ACCEDER_FACTORES')
        <li><a><i class="fa fa-file"></i>CNA<span class="fa fa-chevron-down"></span> </a>
            <ul class="nav child_menu">
                @can('ACCEDER_LINEAMIENTOS')
                    <li class="sub_menu"><a href="{{ route('admin.lineamientos.index') }}"><i
                                    class="fa fa-plus-square-o"></i>Lineamiento</a>
                    </li>
                @endcan
                @can('ACCEDER_FACTORES')
                <li class="sub_menu"><a href="{{ route('admin.factores.index') }}"><i class="fa fa-plus-square-o"></i>Factor</a>
                </li>
                <li class="sub_menu"><a href="{{ route('admin.caracteristicas.index') }}"><i
                                class="fa fa-plus-square-o"></i>Caracteristicas</a>
                </li>
                @endcan
                @can('ACCEDER_AMBITOS')
                    <li class="sub_menu"><a href="{{ route('admin.ambito.index') }}"><i class="fa fa-plus-square-o"></i>Ambito</a>
                    </li>
                @endcan
                @can('ACCEDER_ASPECTOS')
                    <li class="sub_menu"><a href="{{ route('admin.aspectos.index') }}"><i
                                    class="fa fa-plus-square-o"></i>Aspectos</a>
                    </li>
                @endcan
            </ul>
        </li>
        @endcan
    </ul>
</li>
