<div class="page-loader">
    <div class="loader">Cargando...</div>
</div>
<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="widget">
            <div class="widget-posts-image"><a href="#"><img src="{{ asset('titan/assets/images/escudoudec.png')}}"
                                                             alt="Post Thumbnail"/></a></div>
            <li class="text"><a href="#" data-toggle="dropdown"></a>
            </li>
        </div>
        <div class="collapse navbar-collapse" id="custom-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="tittle"><a href="{{route('home')}}">Home</a>
                </li>
                <li class="tittle"><a href="{{route('direccion')}}">Direccion de acreditación</a>
                </li>
                <li class="tittle"><a href="{{route('sistema')}}">Sistema de Autoevaluación</a>
                </li>
                <li class="dropdown"><a href="#" data-toggle="dropdown">Proceso de Autoevaluacion</a>
                </li>
                <li class="title"><a href="{{route('login')}}">login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>