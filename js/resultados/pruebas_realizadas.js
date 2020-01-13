// este fichero va a traducir lo que viene del servidor y se va a mostrar al usuario de la applicaion 
/**
 * 
 * 
 * 
 * Pero si yo lo que quiero es hacer una presentacion diferente de los datos, quizas tendria que tener un
 * fichero js diferente... donde se le den formato a los datos en relacion a lo que yo quiero mostrar
 * 
 */

$(document).ready(function() {   // Le falta aqui los paramertros que va a recibir o no??
    //# busca en el id del elemento html no de la clase. 
    function pruebasRealizadas(){
        var request = $.ajax({
            url: "ajax.php?funcion=getPruebasRealizadas",
            method: "POST",
            data: { 
                "filtro": {
                "grafica" : $("#grafica"),
                "poblacion" : $("#poblacion"), // Aunque aqui poodrian incluirse los tres valores (HSH, TSF, TRANS)
                "fecha": {
                    "desde": $("#desde"),
                    "hasta": $("#hasta")
                    },
                "regiones": $("#regiones"), // al igual que en poblacion, deberia poder contener un array. 
                // estos dos campos son los nuevos que no estan en la otra pagina
                "prueba": $("#prueba"),
                "reactivos": $("#reactivos")
            // Como puede ser que se genere dinamicamente la informacion desde aqui??
                }
            },
            dataType: "json"
        });
    



        // no se como se monta la respuesta

        request.done(function (response) {
            if(response.error == 0){                                                                                            // errores controlados tales como error en la "BD en la consulta"

            }
            else {
                alert(response.errorMessage);
            }
        });

        request.fail(function (jqXHR, textStatus) {
            alert("Ocurrió un error: " + textStatus);                                                                            // para reflejar los errores que no son controlados en el script, como errores de conexion
        });
};