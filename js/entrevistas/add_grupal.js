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

    $(document).on('change', '.id_persona_receptora_buscada', checkPersonaExiste);
    $(document).on('keyup', '.id_persona_receptora_buscada', checkPersonaExiste);

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
                    $("#id_persona_receptora_" + index).val($("#id_persona_receptora_buscada").val());
                    $("#poblacion_" + index).val(response.poblacion).prop( "disabled", true );
                    $("#poblacion_originaria_" + index).prop( "checked", response.poblacion_originaria ).prop( "disabled", true );
                }
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

        request.fail(function (jqXHR, textStatus) {
            alert("Ocurrió un error: " + textStatus);
        });
    }
});