$(document).ready(function() {
    var table = $('#usuarios').DataTable( {
        "ajax": "ajax.php?funcion=getAll",
        "columns": [
            { "data": "nombre" },
            { "data": "apellidos" },
            { "data": "login" },
            { "data": "tipo_de_usuario" },
            { "data": "telefono" },
            {
                "data": "id",
                
                "render": function ( data, type, row ) {
                    if(row.activo) {
                        return "<button class=\"desactivar\" id=\"" + data + "\">Desactivar</button>";
                    }
                    else{
                        return "<button class=\"activar\" id=\"" + data + "\">Activar</button>";
                    }
                }
            }
        ],
        dom: 'Bfrtip',
        "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );

    $('#usuarios tbody').on( 'click', 'button.activar', function () {
        var data = table.row( $(this).parents('tr') ).data();
        alert( data.apellidos);
    } );

} );