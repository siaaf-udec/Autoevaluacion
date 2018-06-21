@extends('admin.layouts.app') 
@section('content') @component('admin.components.panel') @slot('title', 'Grupos de Documentos')
<div class="col-md-12">
    <div class="actions">
        <a class="btn btn-info" data-toggle="modal" data-target="#modal-create-docgroup">
                    <i class="fa fa-plus"></i> Agregar Grupo de Documentos</a></div>
</div>
<br>
<br>

<br>
<div class="col-md-12">
    @component('admin.components.datatable', ['id' => 'documentgroup-table-ajax']) 
    @slot('columns', [ '#' => ['style' => 'width:20px;'], 'id', 'Nombre','Descripcion', 'Acciones' => ['style' => 'width:85px;'] ]) 
    @endcomponent
</div>

<div class="modal fade" id="modal-create-docgroup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registrar Grupo de Documentos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                        {!! Form::open([
                        'route' => 'documental.grupodocumentos.store',
                        'method' => 'POST', 
                        'id' => 'form_crear_grupodocumento',
                        'class' => 'form-horizontal form-label-lef',
                        'novalidate'
                        ])!!}
                            <div class="row">
                                <div class="col-md-12">
                                @include('autoevaluacion.FuentesSecundarias.DocumentGroup._form')
                                </div>
                            </div>
      </div>
      <div class="modal-footer">
      {!! Form::submit('Crear Grupo de Documentos', ['class' => 'btn btn-success']) !!}
      {!! Form::button('Cancelar', ['class' => 'btn red', 'data-dismiss' => 'modal' ]) !!}
                        </div>
      {!! Form::close() !!}
    </div>
  </div>
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

@endpush 
@push('styles')
<!-- Datatables -->
<link href="{{ asset('gentella/vendors/DataTables/datatables.min.css') }}" rel="stylesheet">
<!-- PNotify -->
<link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
<link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
<link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet">

@endpush @push('functions')
<script type="text/javascript">
    $(document).ready(function() {
        let sesion = sessionStorage.getItem("update");
        console.log(sesion);
        if(sesion != null){
            sessionStorage.clear();
            new PNotify({
                                    title: "¡Registro Modificado!",
                                    text: sesion,
                                    type: 'success',
                                    styling: 'bootstrap3'
                                });

        }
        
        table = $('#documentgroup-table-ajax').DataTable({
            processing: true, 
            serverSide: false,
            stateSave: true,
            keys: true,
            dom: 'Bfrtip', 
            buttons: [ 'copy', 'csv', 'excel', 'pdf', 'print' ],
            "ajax": "{{ route('documental.grupodocumentos.data') }}",
            "columns": [
                {data: 'DT_Row_Index'},
                {data: 'PK_GRD_Id', name: 'id', "visible":false},
                {data: 'GRD_Nombre', name: 'Nombre'},
                {data: 'GRD_Descripcion', name: 'Descripcion'},

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
            }
        });
        

        table.on('click', '.remove', function (e) {
                e.preventDefault();
                $tr = $(this).closest('tr');
                var dataTable = table.row($tr).data();
                var route = '{{ route('documental.grupodocumentos.destroy') }}' + '/' + dataTable.PK_GRD_Id;
                var type = 'DELETE';
                dataType: "JSON", 
                SwalDelete(dataTable.PK_GRD_Id);
                


            });
             table.on('click', '.edit', function (e) {
                e.preventDefault();
                $tr = $(this).closest('tr');
                var dataTable = table.row($tr).data();
                var route = '{{ url('admin/documental/grupodocumentos') }}' + '/' + dataTable.PK_GRD_Id + '/edit';
                window.location.replace(route);
                
            });
            
    });
   function SwalDelete(id){
		swal({
			title: 'Esta seguro?',
			text: "El registro sera eliminado permanentemente!",
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
                            url: "{{url('admin/documental/grupodocumentos/destroy')}}/" + id,
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


/*
* Funcion para almacenar dependencia
*/

 $(document).ready(function() {
            var form = $('#form_crear_grupodocumento');
            $(form).parsley({
                trigger: 'change',
                successClass: "has-success",
                errorClass: "has-error",
                classHandler: function (el) {
                return el.$element.closest('.form-group');
                },
                errorsWrapper: '<p class="help-block help-block-error"></p>',
                errorTemplate: '<span></span>',
            });
           
 
            form.submit(function(e) {
        
                e.preventDefault();
                $.ajax({
                    url     : form.attr('action'),
                    type    : form.attr('method'),
                    data    : form.serialize(),
                    dataType: 'json',
                    success: function (response, NULL, jqXHR) {
                        $(form)[0].reset();
                        $(form).parsley().reset();
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
                        $.each(errores, function(name, val) {
                             msg += val + '<br>'; 
                        });
                        new PNotify({
                            title: "Error!",
                            text: msg,
                            type: 'error',
                            styling: 'bootstrap3'
                        });
                    }
                });
            });
        });

</script>

@endpush