{{-- Titulo de la pagina --}}
@section('title', 'Respuestas')

{{-- Contenido principal --}}
@extends('admin.layouts.app')
@section('content') @component('admin.components.panel') @slot('title', 'Respuestas')
@can('CREAR_RESPUESTAS')
    <div class="col-md-12">
        <div class="actions">
            {{ link_to_route('fuentesP.preguntas.index'," Volver ", [], ['class' => 'fa fa-hand-o-left btn btn-warning']) }}
        </div>
    </div>
    <br>
    <br>
    <br>
@endcan
@can('VER_RESPUESTAS')
    <div class="col-md-12">
        @component('admin.components.datatable', ['id' => 'respuestas_table_ajax']) @slot('columns', [
        'id', 'Respuesta','Ponderacion',
    'Acciones' => ['style' => 'width:85px;']]) @endcomponent
    </div>
    @endcomponent
@endcan
@endsection

{{-- Scripts necesarios para el formulario --}} 
@push('scripts')
    <!-- Datatables -->
    <script src="{{asset('gentella/vendors/DataTables/datatables.min.js') }}"></script>
    <script src="{{asset('gentella/vendors/sweetalert/sweetalert2.all.min.js') }}"></script>
    <!-- PNotify -->
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.js') }}"></script>
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.js') }}"></script>

@endpush 

{{-- Estilos necesarios para el formulario --}} 
@push('styles')
    <!-- Datatables -->
    <link href="{{ asset('gentella/vendors/DataTables/datatables.min.css') }}" rel="stylesheet">
    <!-- PNotify -->
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet">

@endpush 

{{-- Funciones necesarias por el formulario --}} 
@push('functions')
    <script type="text/javascript">
        $(document).ready(function () {
            table = $('#respuestas_table_ajax').DataTable({
                processing: true,
                serverSide: false,
                stateSave: true,
                keys: true,
                dom: 'lBfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                "ajax": "{{ route('fuentesP.respuestas.data') }}",
                "columns": [
                    {data: 'PK_RPG_Id', name: 'id', "visible": false},
                    {data: 'RPG_Texto', name: 'Respuesta', className: "all"},
                    {data: 'ponderacion.PRT_Ponderacion', name: 'Ponderacion', className: "desktop"},
                    {
                        defaultContent:
                            '',
                        data: 'action',
                        name: 'action',
                        title: 'Acciones',
                        orderable: false,
                        searchable: false,
                        exportable: false,
                        printable: false,
                        className: 'text-right',
                        render: null,
                        responsivePriority: 2
                    }
                ],
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });


        });

    </script>

@endpush