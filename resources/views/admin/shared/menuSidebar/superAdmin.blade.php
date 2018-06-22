<li><a href="#"><i class="fa fa-users">
    </i> Usuarios<span class="fa fa-chevron-down"></span></a>
    <ul class="nav child_menu">
        <li><a href="{{ route('admin.usuarios.index') }}"><i class="fa fa-user">
            </i>Administrar usuarios</a></li>
        <li><a href="{{ route('admin.rol.index') }}"><i class="fa fa-gavel">
            </i>Roles</a></li>
        <li><a href="tables_dynamic.html"><i class="fa fa-unlock">
            </i>Permisos</a></li>
    </ul>
</li>
<li><a><i class="fa fa-diamond"></i> Super administrador <span class="fa fa-chevron-down"></span></a>
<ul class="nav child_menu">
        <li><a><i class="fa fa-file"></i>CNA<span class="fa fa-chevron-down"></span> </a>
        <ul class="nav child_menu">
            <li class="sub_menu"><a href="{{ route('admin.factores.index') }}"><i class="fa fa-plus-square-o"></i>Factor</a>
            </li>
        </ul>
        </li>
</ul>
</li>