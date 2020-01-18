// este fichero va a traducir lo que viene del servidor y se va a mostrar al usuario de la applicaion 
/**
 * Inicializamos la tabla con las siguientes opciones 
 *  
 */

$(document).ready(function() {   
    var respuesta = [] ;                                                                                                                              //# busca en el id del elemento html no de la clase. 
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
           
            var respuesta = response;

            console.log(response);
            console.log(response[5]["poblacion"]);

            respuesta.forEach(function(resultado){ console.log(resultado.region_de_salud) })




      



            // ChartIt(respuesta);

            // function ChartIt(respuesta){

            //         dividir_objeto();

            //         const ctx = document.getElementById("canvas");
            //         let myChart = new Chart(ctx, {
            //             type: 'bar',
            //             data: {   
            //                 labels: R,
            //                 datasets: [  // cada uno de las poblaciones va a tener un barra que lo represente
            //                     {                               // y esta se recoje en la siguiente propiedad y dentro de parentesis
            //                     label: "TSF",
            //                     data: [1,1,1,1,1],
            //                     backgroundColor: "#ff0000",
            //                     borderWidth:1,
            //                     borderColor: '#000000'                
            //                     },
            //                     {
            //                     label: "HSH",                          
            //                     data: [3,2,3,2,3],                        
            //                     backgroundColor: "#33ccff",
            //                     borderWidth:1,
            //                     borderColor: '#000000',                
            //                     },
            //                     {
            //                     label: "TRANS",
            //                     data: [1,3,5,2,4],
            //                     backgroundColor: "#ff66cc",
            //                     borderWidth:1,
            //                     borderColor: '#000000'
            //                     }
            //                 ]
            //                 },
            //                 options: {
            //                 responsive: true,
            //                 scales: {
            //                     yAxes: [{
            //                         display: true,
            //                         ticks: {
            //                         beginAtZero: true,
            //                         //steps: ,        los campos comentados pueden reactivarse en caso de ser necesario. 
            //                         //stepValue: ,    sin embargo por ahora se mantendran fuera del uso, ya que no alteran el resultado mostrado
            //                         max: 10
            //                         }
            //                     }]
            //                 }
            //             }
            //         })
            //     }


        }); 

            // let region_de_salud = [];

            // for i in response {
            //     region_de_salud [] = push.;
            // }

            // const region_de_salud = response.map( item=> {
            //     console.log("region_de_salud");
            // })
            // const poblacion = response.map( item=> {
            //     console.log(poblacion);
            // })
            // const Total_de_Personas_Alcanzadas = response.map( item=> {
            //     console.log(Total_de_Personas_Alcanzadas);
            // })


        

        request.fail(function (jqXHR, textStatus) {
            alert("Ocurrió un error: " + textStatus);          // para reflejar los errores que no son controlados en el script, como errores de conexion
        });
    };

    $("#enviar").on('click', personasAlcanzadas);


});
