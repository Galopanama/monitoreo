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
                }
            }
        ],
        "searchCols": [
            null,
            null,
            null,
            null,
            null,
            { "search": "^Activo", bRegex: true, bSmart: false},
            null
        ],
        dom: 'Bfrtip',
        "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );

    $(document).on('change', '#mostrar_inactivos', function(){
        let buscar = '^Activo';

        if(this.checked) {
            buscar = '';
        }

        table.column( 5 ).search(buscar, true, false).draw(false);
    });
    

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

    $('#usuarios tbody').on( 'click', 'button.activar', function () {
        var data = table.row( $(this).parents('tr') ).data();

        if (data.tipo_de_usuario === "administrador" && !confirm("¿Estás seguro de que quieres ACTIVAR a este usuario ADMINISTRADOR?")){
            return;
        }

        var request = $.ajax({
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

    /**
     * Vamos a mostrar los posibles mensajes de exito que hubiesen ocurrido
     */
    if ($(".alert-success").find('h4').html() != "") {
        $(".alert-success").toggleClass('d-none');
    }
        

} );