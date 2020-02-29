// Controla que no haya campos invalidos cuando se rellena el formulario
(function () {
    "use strict";
    window.addEventListener(
        "load",
        function () {
            // Recoge todos los formularios a los que queremos aplicarles un formato y verifica que la informacion cumpla las condiciones
            var forms = document.getElementsByClassName("needs-validation");
            // Revisa la informacion para que esta sea correcta
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
    if ($(".alert-danger").find('ul').children().length > 0) {
        $(".alert-danger").toggleClass('d-none');
    }

    $(document).on('change', '#id_cedula_persona_receptora_buscada', checkPersonaExiste);  // DISPARADORES DE JQUERY
    $(document).on('keyup', '#id_cedula_persona_receptora_buscada', checkPersonaExiste);   // change y keyup son eventos de la pagina, relacionados 

    // busca si la persona existe dentro de la base de datos (busca dentro del objeto BD por su id)
    function checkPersonaExiste(){
        var request = $.ajax({
            url: "ajax.php?funcion=buscar",
            method: "POST",
            data: { key: $("#id_cedula_persona_receptora_buscada").val() },
            dataType: "json"
        });

    // Se encarga de organizar la respuesta 
        request.done(function (response) {
            if(response.error == 0){    
                if (response.found == 1) {
                    $("#id_cedula_persona_receptora").val($("#id_cedula_persona_receptora_buscada").val());
                    $("#poblacion").val(response.poblacion).prop( "disabled", true );
                    $("#poblacion_originaria").prop( "checked", response.poblacion_originaria ).prop( "disabled", true );
                }
                else {
                    $("#id_cedula_persona_receptora").val('');
                    $("#poblacion_originaria").prop( "disabled", false );
                    $("#poblacion").prop( "disabled", false );
                }
            }
            else {
                alert(response.errorMessage);
            }
        });

        request.fail(function (jqXHR, textStatus) {
            alert("Ocurrió un error: " + textStatus);  // para reflejar los errores que no son controlados en el script, como errores de conexion
        });
    }



});