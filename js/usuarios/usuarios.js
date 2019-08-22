$(document).ready(function() {
    $('#usuarios').DataTable( {
        "ajax": "ajax.php?funcion=getAll",
        "columns": [
            { "data": "nombre" },
            { "data": "apellidos" },
            { "data": "login" },
            { "data": "tipo_de_usuario" },
            { "data": "telefono" }
        ],
        dom: 'Bfrtip',
        "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );