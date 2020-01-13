// este fichero va a traducir lo que viene del servidor y se va a mostrar al usuario de la applicaion 
/**
 * Inicializamos la tabla con las siguientes opciones 
 *  
 */

$(document).ready(function() {   
                                                                                                                                  //# busca en el id del elemento html no de la clase. 
    function personasAlcanzadas(){
        
        let poblacion = 
            $('input[name="poblacion[]"]:checked').map(function(_, el) {    // Estas dos veriables se declaran para que sea
                return $(el).val();                                         // mas facil trabajar con el JSon. Verdad o no?
            }).get();

        let regiones =
            $('input[name="regiones[]"]:checked').map(function(_, el){
                return $(el).val();
            }).get();


        var request = $.ajax({
            url: "ajax.php",
            method: "POST",
            data: { 
                "funcion": "getPersonasAlcanzadas",
                "filtro": {
                    "poblacion" : poblacion, 
                    "fecha": {                     
                        "desde": $("#desde").val(),
                        "hasta": $("#hasta").val()
                        },
                    "regiones": regiones  
            
                }
            },
            dataType: "json"
        });

        /** Esta parte... no tengo muy claro lo que hace. Dice algo asi:
         * 
         * Cuando la variable request se procesa correctamente, si devuelve un error = a 0... ??
         *      y si devuleve un error message, imprimelo en una ventana emergente para informar. (que es lo que me pasa amenudo)
         * 
         * 
         * Si le peticion falla, imprime un mensaje en una ventana emergente con un mensaje 
         * 
         * */ 
        
        request.done(function (response) {
           
            // var poblaciones = array["TRANS", "HSH", "TSF"];
            
            let poblacion = document.querySelector('poblacion');
            console.log(poblacion);
            console.log('Hola');

            function ajustarObjetivoAnual(poblacion){ 
                if (poblacion == "TRANS") { ObjetivoAnual = 100 };  // ObejtivoAnual es un numero especifico para
                if (poblacion == "HSH") { ObjetivoAnual = 350 };    // cada organizacion. 
                if (poblacion == "TSF") { ObjetivoAnual= 125 };       
            };

            console.log(ajustarObjetivoAnual());
          
        });

        request.fail(function (jqXHR, textStatus) {
            alert("Ocurrió un error: " + textStatus);          // para reflejar los errores que no son controlados en el script, como errores de conexion
        });
    };

    $("#enviar").on('click', personasAlcanzadas);


});
