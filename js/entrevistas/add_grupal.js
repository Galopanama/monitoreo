// Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
    "use strict";
    window.addEventListener( //Listener pertenece a la ventada del navegador
        "load", // este es el evento 
        function () {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName("needs-validation"); //
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function (form) { // forma larga de hacer un for. 
                form.addEventListener(
                    "submit",
                    function (event) {
                        if (form.checkValidity() === false) {   // funcion propia de javascript
                            event.preventDefault();             // para el envio si no esta listo 15 y 16
                            event.stopPropagation();
                        }                                       // evita que el formulario se envie si hay fallos basicos a la hora de completarlo
                        form.classList.add("was-validated");
                    },
                    false
                );
            });
        },
        false
    );
})();                                                           // aqui viene dado desde bootstrap vbasico que trabajo. index.js bootstrap trae un javascript basico...

$(document).ready(function() {
    if ($(".alert-danger").find('ul').children().length > 0) {  // mira si hay mensajes de error que son invisibles.
        $(".alert-danger").toggleClass('d-none');               // si los hay, los pone visibles
    }

    $(document).on('change', '.id_persona_receptora_buscada', checkPersonaExiste); //Jquery disparador cada vez que cambie id... ejecuta la funcion
    $(document).on('keyup', '.id_persona_receptora_buscada', checkPersonaExiste);
                                                        //. busca a todos los elementos que tengas esa clase

    function checkPersonaExiste(){
        var request = $.ajax({ 
            url: "ajax.php?funcion=buscar",
            method: "POST",
            data: { key: $(this).val() },
            dataType: "json" 
        });

        let index = $(this).attr("id").substring($(this).attr("id").lastIndexOf('_') + 1);

        request.done(function (response) {  // que pasa cuando no se ha enviado sin fallo 
            if(response.error == 0){        // response en un parametro que se le pasa a la funcion done
                if (response.found == 1) {
                    $("#id_persona_receptora_" + index).val($("#id_persona_receptora_buscada").val());
                    $("#poblacion_" + index).val(response.poblacion).prop( "disabled", true ); // cambia el atributo
                    $("#poblacion_originaria_" + index).prop( "checked", response.poblacion_originaria ).prop( "disabled", true );
                }                           // el index se refiere a la posicion en que se han enviado dentro de todas las filas
                else {
                    $("#id_persona_receptora_" + index).val('');
                    $("#poblacion_originaria_" + index).prop( "disabled", false );
                    $("#poblacion_" + index).prop( "disabled", false );
                }
            }
            else {
                alert(response.errorMessage);
            }
        });

        request.fail(function (jqXHR, textStatus) { // 
            alert("Ocurrió un error: " + textStatus);// se envia con fallo y este es el mensaje de vuelta.
        });
    }
});