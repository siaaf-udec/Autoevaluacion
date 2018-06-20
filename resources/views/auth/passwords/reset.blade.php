@extends('layouts.app')

@section('content')

<div class="form login_form">
    <section class="login_content">
        {!! Form::open(['id' => 'form-login', 'method' => 'POST', 'route' => 'password.request']) !!}
        @csrf        
        <input type="hidden" name="token" value="{{ $token }}">
        <h1>Restablecer</h1>
        {{ $email }}
        <div>
            {!! Form::email('email', $email ?? old('email'), ['class' => 'form-control', 'placeholder' => 'Correo', 'required', 'autofocus', 'max'
            => '60']) !!}
        </div>
        <div>
            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Contraseña', 'required']) !!}

        </div>
        <div>
            {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Repite la contraseña', 'required']) !!}
        
        </div>
        <div>
            {!! Form::submit('restablecer', ['class' => 'btn btn-default submit']) !!} 
        </div>

        <div class="clearfix"></div>

        <div class="separator">
    @include('shared.footer')
        </div>
        {!! Form::close() !!}
    </section>
</div>
@endsection
@push('styles')
<!-- PNotify -->
<link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
<link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
<link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet"> 
@endpush @push('scripts')
<!-- PNotify -->
<script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.js') }}"></script>
<script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>
<script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.js') }}"></script>


@foreach ($errors->all() as $error)
<script type="text/javascript">
    new PNotify({ title: 'Error!', text: '{{ $error }}', type: 'error', styling: 'bootstrap3' });

</script>
@endforeach 
@endpush