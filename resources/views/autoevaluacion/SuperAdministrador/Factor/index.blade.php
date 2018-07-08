{{-- Titulo de la pagina --}}
@section('title', 'Factores')
{{-- Contenido principal --}}
@extends('admin.layouts.app')

@section('content') @component('admin.components.panel') @slot('title', 'Factores')
<div class="col-md-12">
    <div class="actions">
        <a href="{{ route('admin.factores.create') }}" class="btn btn-info">
            <i class="fa fa-plus"></i> Agregar Factores</a></div>
</div>
<br>
<br>
<br>
<div class="col-md-12">
    @component('admin.components.datatable', ['id' => 'factor-table-ajax']) @slot('columns', [ 'id', 'Nombre', 'Descripcion', 'Identificador' , 'Ponderacion' ,'Estado','Lineamiento',
    'Acciones' => ['style' => 'width:85px;'] ]) @endcomponent

</div>
@endcomponent
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
            console.log(sesion);
            if (sesion != null) {
                sessionStorage.clear();
                new PNotify({
                    title: "Factor Modificado!",
                    text: sesion,
                    type: 'success',
                    styling: 'bootstrap3'
                });
            }
            table = $('#factor-table-ajax').DataTable({
                processing: true,
                serverSide: false,
                stateSave: true,
                keys: true,
                dom: 'LBfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                "ajax": "{{ route('admin.factores.data') }}",
                "columns": [
                    {data: 'PK_FCT_Id', name: 'id', "visible": false},
                    {data: 'FCT_Nombre', name: 'Nombre'},
                    {data: 'FCT_Descripcion', name: 'Descripcion'},
                    {data: 'FCT_Identificador', name: 'Identificador'},
                    {data: 'FCT_Ponderacion_factor', name: 'Ponderacion'},
                    {data: 'estado.nombre_estado', name: 'Estado'},
                    {data: 'lineamiento.nombre', name: 'Lineamiento'},
                    {
                        defaultContent:
                            '<a href="javascript:;" class="btn btn-simple btn-danger btn-sm remove" data-toggle="confirmation"><i class="fa fa-trash"></i></a>' +
                            '<a href="javascript:;" class="btn btn-simple btn-info btn-sm edit" data-toggle="confirmation"><i class="fa fa-pencil"></i></a>',
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
                var route = '{{ url('admin/factores') }}' + '/' + dataTable.PK_FCT_Id;
                var type = 'DELETE';
                dataType: "JSON",
                    SwalDelete(dataTable.PK_FCT_Id, route);
            });
            table.on('click', '.edit', function (e) {
                e.preventDefault();
                $tr = $(this).closest('tr');
                var dataTable = table.row($tr).data();
                var route = '{{ url('admin/factores/') }}' + '/' + dataTable.PK_FCT_Id + '/edit';
                window.location.replace(route);
            });

        });

        function SwalDelete(id, route) {
            swal({
                title: 'Esta seguro?',
                text: "El factor sera eliminado permanentemente!",
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