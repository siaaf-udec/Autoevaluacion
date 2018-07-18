@extends('public.layouts.app')
@section('content')
<section class="bg-dark-30 showcase-page-header module parallax-bg" data-background="{{ asset('titan/assets/images/fondo_2.jpg') }}">
        <div class="titan-caption">
            <div class="caption-content">
                <div class="font-alt mb-30 titan-title-size-1">Autoevaluación y acreditación</div>
                <div class="font-alt mb-40 titan-title-size-4">Sistema de información de Autoevaluación v 3.0</div>
            </div>
        </div>
</section>
<br></br>
<div class="titan-caption">
    <div class="caption-content">
        @foreach ($encuestas as $encuesta)
            @if($encuesta->proceso->programa)
            <td><a href="/grupos/{{ $encuesta->proceso->PK_PCS_Id }}" class="btn btn-d btn-round">
            {{$encuesta->proceso->programa->sede->SDS_Nombre}}&nbsp;{{$encuesta->proceso->PCS_Nombre}}&nbsp;{{$encuesta->proceso->programa->PAC_Nombre}}
            </a></td>
            @else
            <td><a href="/grupos/{{ $encuesta->proceso->PK_PCS_Id }}" class="btn btn-d btn-round">
            Insitucional&nbsp;{{$encuesta->proceso->PCS_Nombre}}
            </a></td>
            @endif
        @endforeach
    </div>
</div>
<br></br>
@endsection