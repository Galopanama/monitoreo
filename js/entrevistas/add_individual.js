// Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
    "use strict";
    window.addEventListener(
        "load",
        function () {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName("needs-validation");
            // Loop over them and prevent submission
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

    $(document).on('change', '#id_persona_receptora_buscada', checkPersonaExiste);                                              // DISPARADORES DE JQUERY
    $(document).on('keyup', '#id_persona_receptora_buscada', checkPersonaExiste);                                                // change y keyup son eventos de la pagina, relacionados 
                                                                                                                                  //# busca en el id del elemento html no de la clase. 
    function checkPersonaExiste(){
        var request = $.ajax({
            url: "ajax.php?funcion=buscar",
            method: "POST",
            data: { key: $("#id_persona_receptora_buscada").val() },
            dataType: "json"
        });

        request.done(function (response) {
            if(response.error == 0){                                                                                            // errores controlados tales como error en la "BD en la consulta"
                if (response.found == 1) {
                    $("#id_persona_receptora").val($("#id_persona_receptora_buscada").val());
                    $("#poblacion").val(response.poblacion).prop( "disabled", true );
                    $("#poblacion_originaria").prop( "checked", response.poblacion_originaria ).prop( "disabled", true );
                }
                else {
                    $("#id_persona_receptora").val('');
                    $("#poblacion_originaria").prop( "disabled", false );
                    $("#poblacion").prop( "disabled", false );
                }
            }
            else {
                alert(response.errorMessage);
            }
        });

        request.fail(function (jqXHR, textStatus) {
            alert("Ocurrió un error: " + textStatus);                                                                            // para reflejar los errores que no son controlados en el script, como errores de conexion
        });
    }
});