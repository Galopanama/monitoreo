/**
 * Este fichero va a dar formato a la informacion que viene del servidor en respuesta a la peticion de 
 * Entrevsitas Individuales
 * 
 * Inicializamos la tabla con las siguientes opciones
 */
$(document).ready(function() {
    var table = $('#entrevistasIndividuales').DataTable( {// plugin de JQuery al que le das las colunas de una clase. llama al ajax
        "ajax": "ajax.php?funcion=getAllIndividuales",
        "columns": [
            // La primera columna nos permitirá expandir para mostrar datos extra
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "nombre_promotor" },
            { "data": "fecha" },
            { "data": "region_de_salud" },
            { "data": "area" },
            { "data": "condones_entregados" },
            { "data": "lubricantes_entregados" },
            { "data": "materiales_educativos_entregados" },
            { 
                "data": "uso_del_condon",
                "render": function ( data, type, row ) {// parametro como se representan . Es un parametro de la columna
                    if(row.uso_del_condon) { // la funcion viene asi por fuerza... 
                        return "Sí";
                    }
                    else{
                        return "No";
                    }
                }
            },
            {
                "data": "uso_de_alcohol_y_drogas_ilicitas",                
                "render": function ( data, type, row ) {
                    if(row.uso_de_alcohol_y_drogas_ilicitas) {
                        return "Sí";
                    }
                    else{
                        return "No";
                    }
                }
            }
            ,
            {
                "data": "informacion_clam",                
                "render": function ( data, type, row ) {
                    if(row.informacion_clam) {
                        return "Sí";
                    }
                    else{
                        return "No";
                    }
                }
            }
            ,
            {
                "data": "referencia_a_pruebas_de_vih",                
                "render": function ( data, type, row ) {
                    if(row.referencia_a_pruebas_de_vih) {
                        return "Sí";
                    }
                    else{
                        return "No";
                    }
                }
            }
            ,
            {
                "data": "referencia_a_clinica_tb",                
                "render": function ( data, type, row ) {
                    if(row.referencia_a_clinica_tb) {
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

    
    // Se añade la funcion para desplegar la informacion de los usuarios
    $('#entrevistasIndividuales tbody').on('click', 'td.details-control', function () {
        let tr = $(this).closest('tr');
        let row = table.row( tr );
 
        if ( row.child.isShown() ) {
            // La ventana (submenu) esta abierto y ordena cerrarlo
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // La ventana (submenu) esta cerrada y al activarlo, se abrirá
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );

    // Se da el formato de la fila 
    function format ( d ) {
        let tabla = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
        
            tabla += '<tr>';
            tabla +=    '<td>Cédula</td>';
            tabla +=    '<td>' + d.id_cedula_persona_receptora + '</td>';
            tabla += '</tr>';

            tabla += '<tr>';
            tabla +=    '<td>Población originaria</td>';
            if(d.poblacion_originaria==1){
                tabla +=    '<td>Sí</td>';
            }
            else{
                tabla +=    '<td>No</td>';
            }
            tabla += '</tr>';

            tabla += '<tr>';
            tabla +=    '<td>Población</td>';
            tabla +=    '<td>' + d.poblacion + '</td>';
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