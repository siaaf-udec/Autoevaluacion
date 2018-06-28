@extends('admin.layouts.app')
@section('content')
    @component('admin.components.panel') @slot('title', 'Documentos Institucionales')

    <div class="col-md-12">
        <div class="actions">
            <a href="{{ route('documental.documentoinstitucional.create') }}" class="btn btn-info">
                <i class="fa fa-plus"></i> Agregar Documento Institucional</a></div>
    </div>
    <br>
    <br>
    <br>
    <div class="col-md-12">
        @component('admin.components.datatable', ['id' => 'docinstitucional_table_ajax'])
            @slot('columns', [ 'id', 'Nombre', 'Descripción','Link','Grupo de Documentos', 'Archivo','Acciones' => ['style'
            => 'width:115px;']]) @endcomponent

    </div>
    @endcomponent
@endsection
@push('scripts')
    <!-- Datatables -->
    <script src="{{asset('gentella/vendors/DataTables/datatables.min.js') }}"></script>
    <script src="{{asset('gentella/vendors/sweetalert/sweetalert2.all.min.js') }}"></script>
    <!-- PNotify -->
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.js') }}"></script>
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.js') }}"></script>



@endpush @push('styles')
    <!-- Datatables -->
    <link href="{{ asset('gentella/vendors/DataTables/datatables.min.css') }}" rel="stylesheet">
    <!-- PNotify -->
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet">
@endpush @push('functions')
    <script type="text/javascript">
        $(document).ready(function () {

            let sesion = sessionStorage.getItem("update");
            console.log(sesion);
            if (sesion != null) {
                sessionStorage.clear();
                new PNotify({
                    title: "Documento Insititucional Modificado!",
                    text: sesion,
                    type: 'success',
                    styling: 'bootstrap3'
                });
            }
            table = $('#docinstitucional_table_ajax').DataTable({
                processing: true,
                serverSide: false,
                stateSave: true,
                keys: true,
                dom: 'lBfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                "ajax": "{{ route('documental.documentoinstitucional.data') }}",
                "columns": [
                    {data: 'PK_DOI_Id', name: 'id', "visible": false},
                    {data: 'DOI_Nombre', name: 'Nombre'},
                    {data: 'DOI_Descripcion', name: 'Descripcion'},
                    {data: 'link', name: 'Link'},
                    {data: 'grupodocumento.nombre', name: 'Grupo de Documentos'},
                    {data: 'archivo.nombre_archivo', name: 'Archivo'},
                    {
                        defaultContent:
                            '<a href="javascript:;" class="btn btn-simple btn-danger btn-sm remove" data-toggle="confirmation"><i class="fa fa-trash"></i></a>' +
                            '<a href="javascript:;" class="btn btn-simple btn-info btn-sm edit" data-toggle="confirmation"><i class="fa fa-pencil"></i></a>' +
                            '<a href="javascript:;" class="btn btn-simple btn-success btn-sm download" data-toggle="confirmation"><i class="fa fa-download"></i></a>',
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
                var route = '{{ url('admin/documental/documentoinstitucional') }}' + '/' + dataTable.PK_DOI_Id;
                var type = 'DELETE';
                dataType: "JSON",
                    SwalDelete(dataTable.PK_DOI_Id, route);
            });
            table.on('click', '.edit', function (e) {
                e.preventDefault();
                $tr = $(this).closest('tr');
                var dataTable = table.row($tr).data();
                var route = '{{ url('admin/documental/documentoinstitucional/') }}' + '/' + dataTable.PK_DOI_Id + '/edit';
                window.location.replace(route);
            });
            table.on('click', '.download', function (e) {
                e.preventDefault();
                $tr = $(this).closest('tr');
                var dataTable = table.row($tr).data();
                var route = '{{ url('storage/documentosinstitucionales') }}' + '/' + 'cursos.txt';
                /*var type='DOWNLOAD';
                descargarArchivo('cursos.txt', route);*/
                window.location.replace(route);
            });

        });

        function SwalDelete(id, route) {
            swal({
                title: 'Esta seguro?',
                text: "El Documento sera eliminado permanentemente!",
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

        function descargarArchivo(id, route) {
            swal({
                title: 'Esta seguro?',
                text: "El Documento sera eliminado permanentemente!",
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
                            type: 'DOWNLOAD',
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