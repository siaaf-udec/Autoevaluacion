@include('public.shared.design')
@include('public.shared.head')
@include('public.shared.header')
</head>
<body data-spy="scroll" data-target=".onpage-navigation" data-offset="60">
<main>
    <div class="main">
        <section class="module bg-dark-30" data-background="{{ asset('titan/assets/images/fondo_1.jpg')}} ">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <h1 class="module-title font-alt mb-0">
                            Restablecer Contraseña</h1>
                    </div>
                </div>
            </div>
        </section>
        <br>
        </br>
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <h4 class="module-title font-alt mb-0">Restablecer</h4>
                    <hr class="divider-w mt-10 mb-20">
                    <div role="tabpanel">
                        {!! Form::open(['role' => 'form', 'id' => 'form-login', 'method' => 'POST', 'url' => route('password.email')]) !!}
                        <div>
                            <br>
                            </br>
                            {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Correo', 'required', 'autofocus', 'max'=> '60']) !!}
                        </div>
                        <br>
                        </br>
                        <div>
                            {!! Form::submit('Restablecer', ['class' => 'btn btn-default submit']) !!}
                        </div>
                        <br>
                        </br>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <br>
        </br>
        @include('public.shared.footer')
        <div class="scroll-up"><a href="#totop"><i class="fa fa-angle-double-up"></i></a></div>
</main>
@include('public.shared.scripts')
@foreach ($errors->all() as $error)
    <script type="text/javascript">
        new PNotify({title: 'Error!', text: '{{ $error }}', type: 'error', styling: 'bootstrap3'});
    </script>
@endforeach
</body>
</html>