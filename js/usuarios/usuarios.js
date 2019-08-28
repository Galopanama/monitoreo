
/**
 * Inicializamos la tabla con las siguientes opciones
 */
$(document).ready(function() {
    var table = $('#usuarios').DataTable( {
        "ajax": "ajax.php?funcion=getAll",
        "columns": [
            // La primera columna nos permitirá expandir para mostrar datos extra
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "nombre" },
            { "data": "apellidos" },
            { "data": "login" },
            { "data": "tipo_de_usuario" },
            { 
                "data": "telefono",
                "sortable": false
            },
            {
                "data": "activo",                
                "render": function ( data, type, row ) {
                    if(row.activo) {
                        return "Activo";
                    }
                    else{
                        return "No Activo";
                    }
                }
            },
            {
                "data": null,                
                "render": function ( data, type, row ) {
                    if(row.activo) {
                        return "<button class=\"desactivar\">Desactivar</button>";
                    }
                    else{
                        return "<button class=\"activar\">Activar</button>";
                    }
                },
                "sortable": false
            },
            {
                "data": null,                
                "render": function ( data, type, row ) {
                    return '<a href="update.php?id_usuario=' + row.id + '" class="btn btn-sm btn-outline-secondary" role="button" aria-pressed="true">Editar</a>';                    
                },
                "sortable": false
            }
        ],
        // La siguiente línea permite que, por defecto, los usuarios no activos no aparezcan en el listado (aunque internamente se hayan cargado)
        "searchCols": [
            null,
            null,
            null,
            null,
            null,
            null,
            { "search": "^Activo", bRegex: true, bSmart: false},
            null,
            null
        ],
        // Botones para exportar el listado
        dom: 'Bfrtip',
        "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );

    /**
     * Con este "truco" conseguimos que exista un checkbox que permita ver o no los usuarios desactivados
     */
    $(document).on('change', '#mostrar_inactivos', function(){
        let buscar = '^Activo';

        if(this.checked) {
            buscar = '';
        }

        table.column( 6 ).search(buscar, true, false).draw(false);
    });
    
    /**
     * Cuando se pulse el botón desactivar en un usuario, se producirá una llamada ajax
     * que enviará el id del usuario que queremos desactivar
     */
    $('#usuarios tbody').on( 'click', 'button.desactivar', function () {
        var data = table.row( $(this).parents('tr') ).data();

        if (data.tipo_de_usuario === "administrador" && !confirm("¿Estás seguro de que quieres DESACTIVAR a este usuario ADMINISTRADOR?")){
            return;
        }

        var request = $.ajax({
            url: "ajax.php?funcion=desactivar",
            method: "POST",
            data: { id_usuario: data.id },
            dataType: "json"
        });

        request.done(function (response) {
            if(response.error === 0){
                //table.draw(false);
                table.ajax.reload( null, false );
            }
            else {
                alert(response.errorMessage);
            }
        });

        request.fail(function (jqXHR, textStatus) {
            alert("Ocurrió un error: " + textStatus);
        });
                     
    } );

    /**
     * Cuando se pulse el botón activar en un usuario, se producirá una llamada ajax
     * que enviará el id del usuario que queremos activar
     */
    $('#usuarios tbody').on( 'click', 'button.activar', function () {
        let data = table.row( $(this).parents('tr') ).data();

        if (data.tipo_de_usuario === "administrador" && !confirm("¿Estás seguro de que quieres ACTIVAR a este usuario ADMINISTRADOR?")){
            return;
        }

        let request = $.ajax({
            url: "ajax.php?funcion=activar",
            method: "POST",
            data: { id_usuario: data.id },
            dataType: "json"
        });

        request.done(function (response) {
            if(response.error === 0){
                //table.draw(false);
                table.ajax.reload( null, false );
            }
            else {
                alert(response.errorMessage);
            }
        });

        request.fail(function (jqXHR, textStatus) {
            alert("Ocurrió un error: " + textStatus);
        });
                     
    } );

    // Add event listener for opening and closing details
    $('#usuarios tbody').on('click', 'td.details-control', function () {
        let tr = $(this).closest('tr');
        let row = table.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );

    /* Formatting function for row details - modify as you need */
    function format ( d ) {
        let tabla = '';
        switch (d.tipo_de_usuario){
            case 'subreceptor':
                tabla = creaSubtabla(
                    {
                        'Ubicación': d.ubicacion
                    }
                );
                break;
            case 'tecnologo':
                tabla = creaSubtabla(
                    {
                        'Nº de registro': d.numero_de_registro,
                        'Cédula': d.id_cedula
                    }
                );
                break;
            case 'promotor':
                tabla = creaSubtabla(
                    {
                        'Organización': d.organizacion,
                        'Cédula': d.id_cedula,
                        'Subreceptor': d.id_subreceptor
                    }
                );
                break;
        }

        return tabla;
    }

    /**
     * Este método creará una subtabla con los datos necesarios para cada tipo de usuario.
     * Dichos datos deberán pasarse en un objeto json, que deberá tener tantos datos como filas tendrá la tabla
     * @param {json} element El objeto con los datos que se necesitan mostrar
     */
    function creaSubtabla(element) {
        let tabla = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
        for (let key in element){
            tabla += '<tr>';
            tabla +=    '<td>' + key + '</td>';
            tabla +=    '<td>' + element[key] + '</td>';
            tabla += '</tr>';
        }

        tabla += '</table>';

        return tabla;
    }


    /**
     * Vamos a mostrar los posibles mensajes de exito que hubiesen ocurrido
     */
    if ($(".alert-success").find('h4').html() != "") {
        $(".alert-success").toggleClass('d-none');
    }
    
    // Y los mensajes de error
    if ($(".alert-danger").find('p').html() != "") {
        $(".alert-danger").toggleClass('d-none');
    }
    
} );