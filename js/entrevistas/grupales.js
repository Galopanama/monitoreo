/**
 * Este fichero va a dar formato a la informacion que viene del servidor en respuesta a la peticion de 
 * Entrevsitas Grupales
 * 
 * Inicializamos la tabla con las siguientes opciones
 */
$(document).ready(function() {
    var table = $('#entrevistasGrupales').DataTable( {
        "ajax": "ajax.php?funcion=getAllGrupales",
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
                "data": "estilos_autocuidado",
                "render": function ( data, type, row ) {
                    if(row.estilos_autocuidado) {
                        return "Sí";
                    }
                    else{
                        return "No";
                    }
                }
            },
            {
                "data": "ddhh_estigma_discriminacion",                
                "render": function ( data, type, row ) {
                    if(row.ddhh_estigma_discriminacion) {
                        return "Sí";
                    }
                    else{
                        return "No";
                    }
                }
            }
            ,
            {
                "data": "uso_correcto_y_constantes_del_condon",                
                "render": function ( data, type, row ) {
                    if(row.uso_correcto_y_constantes_del_condon) {
                        return "Sí";
                    }
                    else{
                        return "No";
                    }
                }
            },
            {
                "data": "salud_sexual_e_ITS",                
                "render": function ( data, type, row ) {
                    if(row.salud_sexual_e_ITS) {
                        return "Sí";
                    }
                    else{
                        return "No";
                    }
                }
            }
            ,
            {
                "data": "ofrecimiento_y_referencia_a_la_prueba_de_VIH",                
                "render": function ( data, type, row ) {
                    if(row.ofrecimiento_y_referencia_a_la_prueba_de_VIH) {
                        return "Sí";
                    }
                    else{
                        return "No";
                    }
                }
            },
            {
                "data": "CLAM_y_otros_servicios",                
                "render": function ( data, type, row ) {
                    if(row.CLAM_y_otros_servicios) {
                        return "Sí";
                    }
                    else{
                        return "No";
                    }
                }
            },
            {
                "data": "salud_anal",                
                "render": function ( data, type, row ) {
                    if(row.salud_anal) {
                        return "Sí";
                    }
                    else{
                        return "No";
                    }
                }
            },
            {
                "data": "hormonizacion",                
                "render": function ( data, type, row ) {
                    if(row.hormonizacion) {
                        return "Sí";
                    }
                    else{
                        return "No";
                    }
                }
            },
            {
                "data": "apoyo_y_orientacion_psicologico",                
                "render": function ( data, type, row ) {
                    if(row.apoyo_y_orientacion_psicologico) {
                        return "Sí";
                    }
                    else{
                        return "No";
                    }
                }
            },
            {
                "data": "diversidad_sexual_identidad_expresion_de_genero",                
                "render": function ( data, type, row ) {
                    if(row.diversidad_sexual_identidad_expresion_de_genero) {
                        return "Sí";
                    }
                    else{
                        return "No";
                    }
                }
            },
            {
                "data": "tuberculosis_y_coinfecciones",                
                "render": function ( data, type, row ) {
                    if(row.tuberculosis_y_coinfecciones) {
                        return "Sí";
                    }
                    else{
                        return "No";
                    }
                }
            },
            {
                "data": "infecciones_oportunistas",                
                "render": function ( data, type, row ) {
                    if(row.infecciones_oportunistas) {
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
    $('#entrevistasGrupales tbody').on('click', 'td.details-control', function () {
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


    //Vamos a mostrar los posibles mensajes de exito que hubiesen ocurrido
    if ($(".alert-success").find('h4').html() != "") {
        $(".alert-success").toggleClass('d-none');
    }
    
    // Y los mensajes de error
    if ($(".alert-danger").find('p').html() != "") {
        $(".alert-danger").toggleClass('d-none');
    }
    
} );