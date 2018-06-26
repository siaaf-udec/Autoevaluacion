@extends('admin.layouts.app') 
@section('content')
 @component('admin.components.panel') 
 @slot('title', 'Indicadores Documentales') 
 @can('CREAR_INDICADORES_DOCUMENTALES')
<div class="col-md-12">
    <div class="actions">
        <a href="{{ route('documental.indicadores_documentales.create') }}" class="btn btn-info">
                    <i class="fa fa-plus"></i> Agregar Indicador Documental</a></div>
</div>
<br>
<br>
<br>
@endcan 
@can('VER_INDICADORES_DOCUMENTALES')
    <div class="col-md-12">
        @component('admin.components.datatable', 
        ['id' => 'indicadores_documentales_table_ajax'])
        @slot('columns', 
        [ 'id', 
        'Lineamiento', 
        'Factor',
        'Característica',
        'Identificador', 
        'Indicador',
        'Estado',
        'Acciones' => ['style' => 'width:85px;']]) 
        @endcomponent

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
    $(document).ready(function() {
        
        let sesion = sessionStorage.getItem("update");
        console.log(sesion);
        if(sesion != null){
            sessionStorage.clear();
            new PNotify({
                title: "Indicador documental Modificado!",
                text: sesion,
                type: 'success',
                styling: 'bootstrap3'
            });
        }
        table = $('#indicadores_documentales_table_ajax').DataTable({
            processing: true, 
            serverSide: false,
            stateSave: false,
            dom: 'lBfrtip',
            responsive: true,
            buttons: [ 'copy', 'csv', 'excel', 'pdf', 'print' ],
            "ajax": "{{ route('documental.indicadores_documentales.data') }}",
            "columns": [
                {data: 'PK_IDO_Id', name: 'id', "visible":false},
                {data: 'caracteristica.factor.lineamiento.LNM_Nombre', name: 'Lineamiento', className:"all"},
                {data: 'caracteristica.factor.FCT_Nombre', name: 'Caracteristica', className:"min-phone-l"},
                {data: 'caracteristica.CRT_Nombre', name: 'Caracteristica', className:"min-tablet-l"},
                {data: 'IDO_Identificador', name: 'Caracteristica', className:"desktop"},
                {data: 'IDO_Nombre', name: 'Aspecto', className:"desktop"},
                {data: 'estado.ESD_Nombre', name: 'Estado', className:"desktop"},
                 {
                    defaultContent: 
                    '@can('ELIMINAR_INDICADORES_DOCUMENTALES')<a href="javascript:;" class="btn btn-simple btn-danger btn-sm remove" data-toggle="confirmation"><i class="fa fa-trash"></i></a>@endcan' +
                    '@can('MODIFICAR_INDICADORES_DOCUMENTALES')<a href="javascript:;" class="btn btn-simple btn-info btn-sm edit" data-toggle="confirmation"><i class="fa fa-pencil"></i></a>@endcan',
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
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            },
            initComplete: function () {
                this.api().columns([1,2,3]).every( function () {
                    var column = this;
                    var select = $('<select style="width: 100px;"><option value=""></option></select>')
                        .appendTo( $(column.footer()).empty() )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
    
                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );
    
                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' );
                    } );
                } );
            }
            
        });
        
        table.on('click', '.remove', function (e) {
            e.preventDefault();
            $tr = $(this).closest('tr');
            var dataTable = table.row($tr).data();
            var route = '{{ url('admin/documental/indicadores_documentales') }}' + '/' + dataTable.PK_IDO_Id;
            var type = 'DELETE';
            dataType: "JSON", 
            SwalDelete(dataTable.PK_IDO_Id, route);

        });
        table.on('click', '.edit', function (e) {
            e.preventDefault();
            $tr = $(this).closest('tr');
            var dataTable = table.row($tr).data();
            var route = '{{ url('admin/documental/indicadores_documentales/') }}' + '/' + dataTable.PK_IDO_Id + '/edit';
            window.location.replace(route);
        });
            
    });
   function SwalDelete(id, route){
		swal({
			title: 'Esta seguro?',
			text: "El Indicador documental sera eliminado permanentemente!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si, eliminar!',
			showLoaderOnConfirm: true,
			cancelButtonText: "Cancelar",
			preConfirm: function() {
			  return new Promise(function(resolve) {      
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
			     .done(function(response){
			     	swal('Eliminado exitosamente!', response.message, response.status);
			     })
			     .fail(function(){
			     	swal('Oops...', 'Something went wrong with ajax !', 'error');
			     });
			  });
		    },
			allowOutsideClick: false			  
		});	
	}
</script>
@endpush