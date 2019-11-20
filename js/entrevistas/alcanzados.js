// este fichero va a traducir lo que viene del servidor y se va a mostrar al usuario de la applicaion 
/**
 * Inicializamos la tabla con las siguientes opciones
 */
$(document).ready(function() {
    var table = $('#total_por_subreceptor').DataTable( {// plugin de jquery al que le das las colunas de una clase. llama al ajax
        "ajax": "ajax.php?funcion=getAlcanzados",
        "columns": [
            // La primera columna nos permitirá expandir para mostrar datos extra
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''},
            { "data": "total_condones" },
            { "data": "total_lubricantes" },
            { "data": "total_materiales_educativos" },
            { "data": "id_subreceptor"} 
        ],
        // Botones para exportar el listado
        dom: 'Bfrtip',
        "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );

    
    // Add event listener for opening and closing details
    $('#total_por_subreceptor tbody').on('click', 'td.details-control', function () {
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