/**
 * Inicializamos la tabla con las siguientes opciones
 */

$(document).ready(function() {
    var table = $('#pruebas').DataTable( {  // tpl. se relaciona al nombre de la tabla a la que estamos asociando la tabla
        "ajax": "ajax.php?funcion=getAllPruebas",
        "columns": [
            // La primera columna nos permitirá expandir para mostrar datos extra
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "nombre_tecnologo" },
            { "data": "fecha" },
            { 
                "data": "consejeria_pre_prueba",
                "render": function ( data, type, row ) {
                    if(row.consejeria_pre_prueba) {
                        return "Sí";
                    }
                    else{
                        return "No";
                    }
                }
            },
            {
                "data": "consejeria_post_prueba",                
                "render": function ( data, type, row ) {
                    if(row.consejeria_post_prueba) {
                        return "Sí";
                    }
                    else{
                        return "No";
                    }
                }
            }
            ,
            {
                "data": "resultado_prueba",                
                "render": function ( data, type, row ) {
                    if(row.resultado_prueba) {
                        return "Sí";
                    }
                    else{
                        return "No";
                    }
                }
            }
            ,
            {
                "data": "realizacion_prueba",                
                "render": function ( data, type, row ) {
                    if(row.realizacion_prueba) {
                        return "Sí";
                    }
                    else{
                        return "No";
                    }
                }
            }
        ],
        // Botones para exportar el listado
        dom: 'Bfrtip',
        "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );

    
    // Add event listener for opening and closing details
    $('#pruebas tbody').on('click', 'td.details-control', function () {
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
        let tabla = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
        
            tabla += '<tr>';
            tabla +=    '<td>Cédula</td>';
            tabla +=    '<td>' + d.id_persona_receptora + '</td>';
            tabla += '</tr>';
    
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