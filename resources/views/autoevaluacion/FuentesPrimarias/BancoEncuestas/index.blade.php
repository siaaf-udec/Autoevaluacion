{{-- Titulo de la pagina --}}
@section('title', 'Banco de Encuestas')

{{-- Contenido principal --}}
@extends('admin.layouts.app')

@section('content')
    @component('admin.components.panel')
        @slot('title', 'Banco de Encuestas')
        @can('CREAR_BANCO_ENCUESTAS')
            <div class="col-md-12">
                <div class="actions">
                    <a href="{{ route('fuentesP.bancoEncuestas.create') }}" class="btn btn-info">
                        <i class="fa fa-plus"></i> Agregar Encuesta</a></div>
            </div>
            <br>
            <br>
            <br>
        @endcan
        @can('VER_BANCO_ENCUESTAS')
            <div class="col-md-12">
                @component('admin.components.datatable',
                ['id' => 'banco_encuestas_table_ajax'])
                    @slot('columns',
                    [ 'id',
                    'Nombre',
                    'Descripcion',
                    'Acciones' => ['style' => 'width:125px;']])
                @endcomponent
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
            let sesion = sessionStorage.getItem("update");
            if (sesion != null) {
                sessionStorage.clear();
                new PNotify({
                    title: "Proceso Modificado!",
                    text: sesion,
                    type: 'success',
                    styling: 'bootstrap3'
                });
            }
            table = $('#banco_encuestas_table_ajax').DataTable({
                processing: true,
                serverSide: false,
                stateSave: false,
                dom: 'lBfrtip',
                responsive: true,
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                "ajax": {
                    "url":"{{ route('fuentesP.bancoEncuestas.data') }}",
                    complete: function() {
                        $('[data-toggle="tooltip"]').tooltip();
                    }
                },
                "columns": [
                    {data: 'PK_BEC_Id', name: 'id', "visible": false},
                    {data: 'BEC_Nombre', name: 'Nombre', className: "all"},
                    {data: 'BEC_Descripcion', name: 'Descripcion', className: "min-phone-l"},
                    {
                        defaultContent:
                            '@can('ELIMINAR_BANCO_ENCUESTAS')<a href="javascript:;" class="btn btn-simple btn-danger btn-sm remove" data-toggle="confirmation"><i class="fa fa-trash"></i></a>@endcan' +
                            '@can('MODIFICAR_BANCO_ENCUESTAS')<a href="javascript:;" class="btn btn-simple btn-info btn-sm edit" data-toggle="confirmation"><i class="fa fa-pencil"></i></a>@endcan'+
                            '@can('VER_ESTABLECER_PREGUNTAS')<a data-toggle="tooltip" title="Establecer Preguntas" href="javascript:;" class="btn btn-simple btn-warning btn-sm asignar"><i class="fa fa-plus"></i></a>@endcan',
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
                },
            });

            table.on('click', '.remove', function (e) {
                e.preventDefault();
                $tr = $(this).closest('tr');
                var dataTable = table.row($tr).data();
                var route = '{{ url('admin/fuentesPrimarias/bancoEncuestas') }}' + '/' + dataTable.PK_BEC_Id;
                var type = 'DELETE';
                dataType: "JSON",
                    SwalDelete(dataTable.PK_BEC_Id, route);

            });
            table.on('click', '.edit', function (e) {
                e.preventDefault();
                $tr = $(this).closest('tr');
                var dataTable = table.row($tr).data();
                var route = '{{ url('admin/fuentesPrimarias/bancoEncuestas') }}' + '/' + dataTable.PK_BEC_Id + '/edit';
                window.location.href = route;
            });
            table.on('click', '.asignar', function (e) {
                e.preventDefault();
                $tr = $(this).closest('tr');
                var dataTable = table.row($tr).data();
                var route = '{{ url('admin/fuentesPrimarias/establecerPreguntas/') }}' + '/' + dataTable.PK_BEC_Id;
                window.location.href = route;
            });

        });

        function SwalDelete(id, route) {
            swal({
                title: 'Esta seguro?',
                text: "El proceso sera eliminado permanentemente!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar!',
                showLoaderOnConfirm: true,
                cancelButtonText: "Cancelar",
                preConfirm: function () {
                    return new Promise(function (resolve) {
                        $.ajax({
                            type: 'DELETE',
                            url: route,
                            data: {
                                '_token': $('meta[name="_token"]').attr('content'),
                            },
                            success: function (response, NULL, jqXHR) {
                                table.ajax.reload();
                                new PNotify({
                                    title: response.title,
                                    text: response.msg,
                                    type: 'success',
                                    styling: 'bootstrap3'
                                });
                            },
                            error: function (data) {
                                var errores = data.responseJSON.errors;
                                var msg = '';
                                $.each(errores, function (name, val) {
                                    msg += val + '<br>';
                                });
                                new PNotify({
                                    title: "Error!",
                                    text: msg,
                                    type: 'error',
                                    styling: 'bootstrap3'
                                });
                            }
                        })
                            .done(function (response) {
                                swal('Eliminado exitosamente!', response.message, response.status);
                            })
                            .fail(function () {
                                swal('Error', 'La encuesta se encuentra relacionada a un proceso en estado de captura de datos!', 'error');
                            });
                    });
                },
                allowOutsideClick: false
            });
        }
    </script>
@endpush