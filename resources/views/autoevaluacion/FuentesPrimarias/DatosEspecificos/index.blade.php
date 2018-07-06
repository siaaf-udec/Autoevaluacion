@extends('admin.layouts.app')
@section('content')
    @component('admin.components.panel')
        @slot('title', 'Datos Especificos Encuestas')
        @can('CREAR_ENCUESTAS')
            <div class="col-md-12">
                <div class="actions">
                    <a href="{{ route('fuentesP.datosEspecificos.create') }}" class="btn btn-info">
                        <i class="fa fa-plus"></i> Agregar Datos Expecificos</a></div>
            </div>
            <br>
            <br>
            <br>
        @endcan
        @can('VER_ENCUESTAS')
            <div class="col-md-12">
                
            @component('admin.components.datatable', ['id' => 'datosEspecificos-table-ajax']) @slot('columns', [ 'id', 'Fecha Publicacion', 'Fecha Finalizacion', 'Estado','Proceso',  
    'Acciones' => ['style' => 'width:85px;'] ]) @endcomponent

            </div>
            @endcomponent
        @endcan
@endsection
@push('scripts')
    <!-- Datatables -->
    <script src="{{asset('gentella/vendors/DataTables/datatables.min.js') }}"></script>
    <script src="{{asset('gentella/vendors/sweetalert/sweetalert2.all.min.js') }}"></script>
    <!-- PNotify -->
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.js') }}"></script>
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.js') }}"></script>

@endpush
@push('styles')
    <!-- Datatables -->
    <link href="{{ asset('gentella/vendors/DataTables/datatables.min.css') }}" rel="stylesheet">
    <!-- PNotify -->
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet">

@endpush
@push('functions')
    <script type="text/javascript">
        $(document).ready(function () {
            let sesion = sessionStorage.getItem("update");
            console.log(sesion);
            if (sesion != null) {
                sessionStorage.clear();
                new PNotify({
                    title: "Datos Modificados!",
                    text: sesion,
                    type: 'success',
                    styling: 'bootstrap3'
                });

            }
            table = $('#datosEspecificos-table-ajax').DataTable({
                processing: true,
                serverSide: false,
                stateSave: true,
                keys: true,
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                "ajax": "{{ route('fuentesP.datosEspecificos.data') }}",
                "columns": [
                    {data: 'PK_ECT_Id', name: 'id', "visible": false}, 
                    {data: 'ECT_FechaPublicacion', name: 'Fecha Publicacion', className: "desktop"}, 
                    {data: 'ECT_FechaFinalizacion', name: 'Fecha Finalizacion', className: "desktop"}, 
                    {data: 'estado.ESD_Nombre', name: 'Estado', className: "min-phone-l"}, 
                    {data: 'proceso.PCS_Nombre', name: 'Proceso', className: "min-tablet-l"}, 
                    
                    {
                        defaultContent:
                            '@can('ELIMINAR_ENCUESTAS')<a href="javascript:;" class="btn btn-simple btn-danger btn-sm remove" data-toggle="confirmation"><i class="fa fa-trash"></i></a>@endcan' +
                            '@can('MODIFICAR_ENCUESTAS')<a href="javascript:;" class="btn btn-simple btn-info btn-sm edit" data-toggle="confirmation"><i class="fa fa-pencil"></i></a>@endcan'+ 
                             '<a href="javascript:;" class="btn btn-simple btn-primary btn-sm ver" data-toggle="confirmation"><i class="fa fa-question-circle"></i></a>',
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
            table.on('click', '.remove', function (e) {
                e.preventDefault();
                $tr = $(this).closest('tr');
                var dataTable = table.row($tr).data();
                var route = '{{ url('admin/fuentesPrimarias/datosEspecificos/') }}' + '/' + dataTable.PK_ECT_Id;
                var type = 'DELETE';
                dataType: "JSON",
                    SwalDelete(dataTable.PK_ECT_Id, route);

            });
            table.on('click', '.edit', function (e) {
                e.preventDefault();
                $tr = $(this).closest('tr');
                var dataTable = table.row($tr).data();
                var route = '{{ url('admin/fuentesPrimarias/datosEspecificos/') }}' + '/' + dataTable.PK_ECT_Id + '/edit';
                window.location.replace(route);


            });

            table.on('click', '.ver', function (e) {
                e.preventDefault();
                $tr = $(this).closest('tr');
                var dataTable = table.row($tr).data();
                var route = '{{ url('admin/fuentesPrimarias/establecerPreguntas/') }}' + '/' + dataTable.PK_ECT_Id;
                window.location.replace(route);
            });

        });

        function SwalDelete(id, route) {
            swal({
                title: 'Esta seguro?',
                text: "Los datos seran eliminados permanentemente!",
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
                            }
                        })
                            .done(function (response) {
                                swal('Eliminado exitosamente!', response.message, response.status);
                            })
                            .fail(function () {
                                swal('Oops...', 'Something went wrong with ajax !', 'error');
                            });
                    });
                },
                allowOutsideClick: false
            });

        }

    </script>

@endpush