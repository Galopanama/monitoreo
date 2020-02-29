/**
 * El fichero se encarga de invalidar la subida de formularios con campos invalidos o incompletos
 */
(function () {
    "use strict";
    window.addEventListener( //Listener pertenece a la ventada del navegador
        "load", // este es el evento 
        function () {
            // Recoge todos los formularios a los que se quieres dar una validacion de estilo con bootstrap 
            var forms = document.getElementsByClassName("needs-validation"); //
            // Se recorren los formularios y se previene el envio
            var validation = Array.prototype.filter.call(forms, function (form) { 
                form.addEventListener(
                    "submit",
                    function (event) {
                        if (form.checkValidity() === false) {  
                            event.preventDefault();             
                            event.stopPropagation();
                        }                                       
                        form.classList.add("was-validated");
                    },
                    false
                );
            });
        },
        false
    );
})();                                                          

$(document).ready(function() {
    if ($(".alert-danger").find('ul').children().length > 0) {  // mira si hay mensajes de error que son invisibles.
        $(".alert-danger").toggleClass('d-none');               // si los hay, los hace visibles
    }

    $(document).on('change', '.id_cedula_persona_receptora_buscada', checkPersonaExiste); //Jquery disparador cada vez que cambie id... ejecuta la funcion
    $(document).on('keyup', '.id_cedula_persona_receptora_buscada', checkPersonaExiste);
                                                        //. busca a todos los elementos que tengas esa clase

    // busca si la persona existe dentro de la base de datos (busca dentro del objeto BD por su id)                                                    
    function checkPersonaExiste(){
        var request = $.ajax({ 
            url: "ajax.php?funcion=buscar",
            method: "POST",
            data: { key: $(this).val() },
            dataType: "json" 
        });

        let index = $(this).attr("id").substring($(this).attr("id").lastIndexOf('_') + 1);

        request.done(function (response) {  
            if(response.error == 0){        
                if (response.found == 1) {
                    $("#id_cedula_persona_receptora_" + index).val($("#id_cedula_persona_receptora_buscada").val());
                    $("#poblacion_" + index).val(response.poblacion).prop( "disabled", true ); // cambia el atributo
                    $("#poblacion_originaria_" + index).prop( "checked", response.poblacion_originaria ).prop( "disabled", true );
                }                           // el index se refiere a la posicion en que se han enviado dentro de todas las filas
                else {
                    $("#id_cedula_persona_receptora_" + index).val('');
                    $("#poblacion_originaria_" + index).prop( "disabled", false );
                    $("#poblacion_" + index).prop( "disabled", false );
                }
            }
            else {
                alert(response.errorMessage);
            }
        });

        request.fail(function (jqXHR, textStatus) { 
            alert("Ocurrió un error: " + textStatus);// se envia con fallo y este es el mensaje de vuelta.
        });
    }
});