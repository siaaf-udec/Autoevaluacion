
            
            @if(session()->get('id_proceso'))
                let sesion = sessionStorage.getItem("update");
                if (sesion != null) {
                    sessionStorage.clear();
                    new PNotify({
                        title: "Actividad Modificada!",
                        text: sesion,
                        type: 'success',
                        styling: 'bootstrap3'
                    });
                }
                table = $('#actividades_mejoramiento_table_ajax').DataTable({
                    processing: true,
                    serverSide: false,
                    stateSave: true,
                    keys: true,
                    dom: 'lBfrtip',
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                    "ajax": "{{ route('admin.actividades_mejoramiento.data') }}",
                    "columns": [
                        {data: 'PK_ACM_Id', name: 'id', "visible": false},
                        {data: 'caracteristicas.factor.FCT_Nombre', name: 'Factor', className: "min-phone-l"},
                        {data: 'caracteristicas.CRT_Nombre', name: 'Caracteristica', className: "min-phone-l"},
                        {data: 'ACM_Nombre', name: 'Nombre', className: "min-phone-l"},
                        {data: 'ACM_Descripcion', name: 'Descripcion', className: "min-phone-l"},
                        {data: 'ACM_Fecha_Inicio', name: 'Fecha de Inicio', className: "min-phone-l"},
                        {data: 'ACM_Fecha_Fin', name: 'Fecha de Finalizacion', className: "all"},
                        {data: 'responsable', name: 'Responsable', className: "all"},
                        {
                            defaultContent:
                                '@can('ELIMINAR_ACTIVIDADES_MEJORAMIENTO')<a href="javascript:;" class="btn btn-simple btn-danger btn-sm remove" data-toggle="confirmation"><i class="fa fa-trash"></i></a>@endcan' +
                                '@can('MODIFICAR_ACTIVIDADES_MEJORAMIENTO')<a href="javascript:;" class="btn btn-simple btn-info btn-sm edit" data-toggle="confirmation"><i class="fa fa-pencil"></i></a>@endcan',
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