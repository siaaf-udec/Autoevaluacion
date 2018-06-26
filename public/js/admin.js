function dataTable(tabla, data, route) {
    tabla.dataTable({
        processing: true,
        serverSide: false,
        stateSave: true,
        keys: true,
        dom: 'lBfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        "ajax": route,
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

    return tabla;
}

function parsleyInit(form) {
    form.parsley({
        trigger: 'change',
        successClass: "has-success",
        errorClass: "has-error",
        classHandler: function (el) {
            return el.$element.closest('.form-group');
        },
        errorsWrapper: '<p class="help-block help-block-error"></p>',
        errorTemplate: '<span></span>',
    });
}
function selectDinamico(Id_select_1, Id_select_2, ruta, dependientes = []) {
    // Bloqueamos el SELECT de los select2
    $(Id_select_2).prop('disabled', true);

    // Hacemos la lógica que cuando nuestro SELECT cambia de valor haga algo
    $(Id_select_1).change(function () {
        // Guardamos el select de select2
        var select2 = $(Id_select_2);

        // Guardamos el select de select2
        var select1 = $(this);

        if ($(this).val() != '') {
            $.ajax({
                url: ruta + "/" + $(this).val(),
                type: 'GET',
                dataType: 'json',
                beforeSend: function () {
                    select2.prop('disabled', true);
                },
                success: function (r) {
                    select1.prop('disabled', false);

                    // Limpiamos el select
                    select2.find('option').remove();
                    $.each(r, function (key, data) { // indice, valor
                        select2.append('<option value="' + key + '">' + data + '</option>');
                    })

                    for (let i = 0; i < dependientes.length; i++) {
                        $(dependientes[i]).find('option').remove();
                        $(dependientes[i]).prop('disabled', true);
                    }

                    select2.prop('disabled', false);
                },
                error: function () {
                    alert('Ocurrio un error en el servidor ..');
                    select2.prop('disabled', false);
                }
            });
        } else {
            select2.find('option').remove();
            select2.prop('disabled', true);
        }
    })
}