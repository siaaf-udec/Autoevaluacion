@extends('admin.layouts.app')

@section('content')
    @component('admin.components.panel')
        @slot('title', 'Bienvenido a la plataforma Sia.')
    @endcomponent
@endsection