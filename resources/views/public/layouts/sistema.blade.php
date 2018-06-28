@include('public.shared.design')
@include('public.shared.head')
</head>
<body data-spy="scroll" data-target=".onpage-navigation" data-offset="60">
<main>
    @include('public.shared.header')
    <section class="module bg-dark-30" data-background="{{ asset('titan/assets/images/udec.jpg')}} ">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <h1 class="module-title font-alt mb-0">Sistema de autoevaluación</h1>
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
                        <li class="active"><a href="#marco" data-toggle="tab"><span class="fa fa-fw">&#xF0E3;</span>Marco
                                Legal</a>
                        </li>
                        <li><a href="#politica" data-toggle="tab"><span class="fa fa-fw">&#xF0B1;</span>Política</a>
                        </li>
                        <li><a href="#principios" data-toggle="tab"><span class="icon-global"></span>Principios</a>
                        </li>
                        <li><a href="#criterios" data-toggle="tab"><span class="icon-tools-2"></span>Criterios</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="marco">
                            <li>Ley 30 de 1992. Artículo 55. “El programa deberá establecer las formas mediante las
                                cuales realizará su autoevaluación permanente y revisión periódica de su currículo y de
                                los demás aspectos que estime convenientes para su mejoramiento y actualización”
                            </li>
                            <li>Ley 1188 de 2008. Artículo 3. “El desarrollo de una cultura de la autoevaluación, que
                                genere un espíritu crítico y constructivo de mejoramiento continuo”
                            </li>
                            <li>Decreto 1295 de 2010. La institución deberá garantizar: “La existencia o promoción de
                                una cultura de autoevaluación que tenga en cuenta el diseño y aplicación de políticas
                                que involucren a los distintos miembros de la comunidad, y pueda ser verificable a
                                través de evidencias e indicadores de resultado”.
                            </li>
                            <li>Ministerio de Educación Nacional. Subdirección de Aseguramiento de la Calidad de la
                                Educación Superior. Lineamientos Generales para la Autoevaluación en el marco del
                                Artículo 6, Numeral 6.3 del Decreto 1295
                            </li>
                            <br></br><br></br>
                        </div>
                        <div class="tab-pane" id="politica">Es necesario partir de la Política de Calidad de la
                            Educación Superior del Ministerio de Educación Nacional, que tiene como objetivo fundamental
                            velar por la consolidación de culturas de autorregulación que favorezcan y garanticen el
                            continuo mejoramiento de las Instituciones de Educación Superior, de los medios y procesos
                            empleados para el desarrollo de sus funciones misionales y de las condiciones de prestación
                            del Servicio Público de Educación Superior.
                            En consecuencia la política institucional es la siguiente:
                            La Autoevaluación, eje del aseguramiento de la calidad y el mejoramiento continuo en la
                            dinámica académica institucional para lograr la excelencia.
                            Institucionalmente se entiende la autoevaluación como un conjunto de procedimientos
                            valorativos integrados e interdependientes que permiten interpretar críticamente e
                            intervenir la calidad del desarrollo docente, investigativo y de extensión universitaria
                            frente a la misión y la visión institucionales para construir políticas de aseguramiento de
                            la calidad y mejoramiento continuo, con pertinencia social.
                            Es un proceso sistemático y permanente para identificar, obtener y proporcionar información
                            útil acerca del valor y el mérito de las metas, los insumos, los procesos y los productos de
                            los programas académicos, con el fin de proponer alternativas de solución a los problemas
                            identificados y servir de guía para la toma de decisiones.
                            <br></br><br></br>
                        </div>
                        <div class="tab-pane" id="principios">La Autoevaluación y Acreditación en la Universidad de
                            Cundinamarca, estarán regidas por los principios enunciados en el Estatuto General (Acuerdo
                            No. 010 de junio 20 de 2002); principios que constituyen las normas rectoras para la
                            aplicación de todas las disposiciones de la Universidad. De ellos se destacan
                            particularmente:
                            <li>Responsabilidad Social</li>
                            <li>Universalidad</li>
                            <li>Pertinencia</li>
                            <li>Autonomía</li>
                            <li>Excelencia Académica</li>
                            <li>Equidad</li>
                            <li>Transparencia</li>
                            <br></br><br></br>
                        </div>
                        <div class="tab-pane" id="criterios">La Universidad de Cundinamarca acoge como criterios del
                            Modelo y Procedimiento de Autoevaluación los sugeridos por el Consejo Nacional de
                            Acreditación e igualmente los asume en la totalidad de las actividades
                            académico-administrativas
                            <div class="content-box">
                                <div class="content-box-image"><img
                                            src="{{ asset('titan/assets/images/criterios.jpg') }}" alt=" "/></div>
                            </div>
                            <br></br><br></br>
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