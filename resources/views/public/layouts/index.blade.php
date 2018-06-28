@include('public.shared.design')
@include('public.shared.head')
</head>
<body data-spy="scroll" data-target=".onpage-navigation" data-offset="60">
<main>
    @include('public.shared.header')
    <section class="bg-dark-30 showcase-page-header module parallax-bg"
             data-background="{{ asset('titan/assets/images/fondo_2.jpg') }}">
        <div class="titan-caption">
            <div class="caption-content">
                <div class="font-alt mb-30 titan-title-size-1">Autoevaluación y acreditación.</div>
                <div class="font-alt mb-40 titan-title-size-4">Sistema de informacion de Autoevaluación</div>
                <a class="section-scroll btn btn-border-w btn-round" href="#demos">Procesos de Autoevaluación</a>
            </div>
        </div>
    </section>
    @include('public.shared.footer')
    div class="scroll-up"><a href="#totop"><i class="fa fa-angle-double-up"></i></a></div>
</main>
@include('public.shared.scripts')
</body>
</html>