@include('public.shared.design')
@include('public.shared.head')
</head>
<body data-spy="scroll" data-target=".onpage-navigation" data-offset="60">
<main>
    @include('public.shared.header')
    <section class="module bg-dark-30" data-background="{{ asset('titan/assets/images/fondo_1.jpg')}} ">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <h1 class="module-title font-alt mb-0">Direccion de autoevaluacion y acreditacion</h1>
                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <br>
                </br>
                <h4 class="font-alt mb-0">Descripción</h4>
                <hr class="divider-w mt-10 mb-20">
                <div role="tabpanel">
                    <ul class="nav nav-tabs font-alt" role="tablist">
                        <li class="active"><a href="#quienes" data-toggle="tab"><span class="fa fa-fw">&#xF007;</span>¿Quienes
                                somos?</a>
                        </li>
                        <li><a href="#mision" data-toggle="tab"><span class="fa fa-fw">&#xF19C;</span>Misión</a>
                        </li>
                        <li><a href="#vision" data-toggle="tab"><span class="fa fa-fw">&#xF135;</span>Visión</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="quienes">La Dirección de Autoevaluación y Acreditación es una
                            dependencia de la Vicerrectoría Académica, encargada de diseñar, estructurar, implementar y
                            hacer seguimiento al sistema de autoevaluación en función de la acreditación y calidad de
                            los programas de pregrado y posgrado de la Universidad de Cundinamarca.
                            <div class="content-box">
                                <div class="content-box-image"><img
                                            src="{{ asset('titan/assets/images/acreditacion.jpg') }}" alt=" "/></div>
                            </div>
                        </div>
                        <div class="tab-pane" id="mision">Consolidar la cultura de autoevaluación como proceso
                            permanente de la institución, liderando la política de aseguramiento de la calidad y
                            mejoramiento de la oferta académica a partir de estrategias participativas.
                            <br>
                            </br>
                            <br>
                            </br>
                            <br>
                            </br>
                        </div>
                        <div class="tab-pane" id="vision">En el año 2018 la comunidad universitaria de la UDEC ha
                            apropiado una cultura de autorregulación, mejoramiento y aseguramiento continuo de la
                            calidad del servicio de educación superior reconocido por la sociedad y el estado por su
                            Alta Calidad
                            <br>
                            </br>
                            <br>
                            </br>
                            <br>
                            </br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('public.shared.footer')
    div class="scroll-up"><a href="#totop"><i class="fa fa-angle-double-up"></i></a></div>
</main>
@include('public.shared.scripts')
</body>
</html>