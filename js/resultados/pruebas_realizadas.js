/**
 * Este fichero esta incompleto y pertence al las tarea que se pretendia conseguir de 
 * visualizar las pruebas que se han realizado.
 * Puede reutilizarse o destruirse. A gusto del desarrollador
 * 
 * Tambien contine aclaraciones sobre como funciona JavaScript sintacticamnete
 */

$(document).ready(function() {   
    //# busca en el id del elemento html no de la clase. 
    function pruebasRealizadas(){
        var request = $.ajax({
            url: "ajax.php?funcion=getPruebasRealizadas",
            method: "POST",
            data: { 
                "filtro": {
                "grafica" : $("#grafica"),
                "poblacion" : $("#poblacion"), 
                "fecha": {
                    "desde": $("#desde"),
                    "hasta": $("#hasta")
                    },
                "regiones": $("#regiones"), 
                // al igual que en poblacion, deberia poder contener un array. 
                // estos dos campos son los nuevos que no estan en la otra pagina
                "prueba": $("#prueba"),
                "reactivos": $("#reactivos")
                }
            },
            dataType: "json"
        });
    



        // Aqui debe mostrarse la construccion de "response". 
        // Se recomienda observar el fichero de PersonasAlcanzadas


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
    }