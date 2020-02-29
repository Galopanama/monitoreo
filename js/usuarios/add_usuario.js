/**
 * El fichero se encarga de invalidar la subida de formularios con campos invalidos o incompletos
 */
(function () {
    "use strict";
    window.addEventListener(
        "load",
        function () {
            // Recoge todos los formularios a los que se quieres dar una validacion de estilo con bootstrap 
            var forms = document.getElementsByClassName("needs-validation");
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
    if ($(".alert-danger").find('ul').children().length > 0) {
        $(".alert-danger").toggleClass('d-none');
    }

    $(document).on('change', '#tipo_de_usuario', showSpecificFields);

    function showSpecificFields() {
        // Primero ocultamos todos los tipos específicos
        $('.tipo_hidden').addClass('d-none');

        // Y luego mostramos el tipo particular
        $('.' + $('#tipo_de_usuario').val()).toggleClass('d-none');
    }

    // Llamamos al cargar la página, por si estuviésemos modificando, o volviésemos de un error
    showSpecificFields();
});