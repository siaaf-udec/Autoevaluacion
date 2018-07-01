@extends('admin.layouts.app') 
@section('content') @component('admin.components.panel') 
@slot('title', 'Ponderacion de Respuestas')
<div class="col-md-12">
    @can('CREAR_PONDERACION_RESPUESTAS')
    <div class="actions">
        {{ link_to_route('fuentesP.tipoRespuesta.index'," Volver ", [], ['class' => 'fa fa-hand-o-left btn btn-warning']) }}
    </div> 
    @endcan

</div>
@can('VER_PONDERACION_RESPUESTAS')
<br>
<br>
<br>
<div class="col-md-12">
    @component('admin.components.datatable', 
    ['id' => 'ponderacionRespuesta_table_ajax']) 
    @slot('columns', [ 'id', 'Ponderacion','Acciones' =>
    ['style' => 'width:85px;'] ]) 
    @endcomponent

</div>
@endcomponent 
@endcan
@endsection
 @push('scripts')
<!-- validator -->
<script src="{{ asset('gentella/vendors/parsleyjs/parsley.min.js') }}"></script>
<script src="{{ asset('gentella/vendors/parsleyjs/i18n/es.js') }}"></script>
<!-- Datatables -->
<script src="{{asset('gentella/vendors/DataTables/datatables.min.js') }}"></script>
<script src="{{asset('gentella/vendors/sweetalert/sweetalert2.all.min.js') }}"></script>
<!-- PNotify -->
<script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.js') }}"></script>
<script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>
<script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('gentella/vendors/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/admin.js') }}"></script>



@endpush 
@push('styles')
<!-- Datatables -->
<link href="{{ asset('gentella/vendors/DataTables/datatables.min.css') }}" rel="stylesheet">
<!-- PNotify -->
<link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
<link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
<link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet">

<link href="{{ asset('gentella/vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet">
@endpush 
@push('functions')
<script type="text/javascript">
    $(document).ready(function() {
        var formCreate = $('#form_ponderacionRespuestas');

        var data, routeDatatable;
        data =  [
                {data: 'PK_PRT_Id', name: 'id', "visible":false},
                {data: 'PRT_Ponderacion', name: 'Ponderacion', className:"min-table-p"},
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
        ];
        routeDatatable = "{{ route('fuentesP.ponderacionRespuesta.data') }}";
        table = $('#ponderacionRespuesta_table_ajax').DataTable({
            processing: true,
            serverSide: false,
            stateSave: true,
            keys: true,
            dom: 'lBfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            "ajax": routeDatatable,
            "columns": data,
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
        $(formCreate).parsley({
            trigger: 'change',
            successClass: "has-success",
            errorClass: "has-error",
            classHandler: function (el) {
                return el.$element.closest('.form-group');
            },
            errorsWrapper: '<p class="help-block help-block-error"></p>',
            errorTemplate: '<span></span>',
        });   
    });

</script>

@endpush