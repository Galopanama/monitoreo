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
           
            let regiones_de_salud = {};
            let poblaciones = {};
            poblaciones["TSF"] = {
                backgroundColor: "#ff0000",
                borderColor: "#000",
                borderWidth:1,
            };
            poblaciones["HSH"] = {
                backgroundColor: "#33ccff",
                borderColor: "#000",
                borderWidth:1,
            };
            poblaciones["TRANS"] = {
                backgroundColor: "#ff66cc",
                borderColor: "#000",
                borderWidth:1
            };
            nombre_regiones = [];

           response.forEach(function(resultado){ 
                poblaciones[resultado.poblacion][region_de_salud] = resultado.Total_de_Personas_Alcanzadas;
                nombre_regiones.push(resultado.region_de_salud);

                // if (!resultado.region_de_salud in regiones_de_salud){
                //     // Si la region no existe, la creamos, y ponemos sus poblaciones a 0
                //     regiones_de_salud[resultado.region_de_salud] = poblaciones;
                //     nombre_regiones.push(resultado.region_de_salud);
                // }

                // regiones_de_salud[resultado.region_de_salud][resultado.poblacion] = resultado.Total_de_Personas_Alcanzadas;                
            });

            dataset = [];
            poblaciones.forEach(function(poblacion, idx){
                data = {
                    label: idx,
                    // recorrer el array de nombre regiones para generar un array con el número de alcanzados de dichas regiones
                    // para esta poblacion
                    data: nombre_regiones.map(function(reg){
                        return poblacion.reg;
                    }),
                    backgroundColor: "#ff0000",
                    borderWidth:1,
                    borderColor: '#000000'
                };
                dataset.push(data);
            });


            ChartIt(regiones_de_salud, nombre_regiones);

            function ChartIt(datos){

                    dividir_objeto();

                    const ctx = document.getElementById("canvas");
                    let myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {   
                            labels: nombre_regiones,
                            datasets: dataset,
                            options: {
                                    responsive: true,
                                    scales: {
                                        yAxes: [{
                                            display: true,
                                            ticks: {
                                            beginAtZero: true,
                                            //steps: ,        los campos comentados pueden reactivarse en caso de ser necesario. 
                                            //stepValue: ,    sin embargo por ahora se mantendran fuera del uso, ya que no alteran el resultado mostrado
                                            max: 10
                                            }
                                        }]
                                    }
                                }
                    }});
            }


        }); 
    

        request.fail(function (jqXHR, textStatus) {
            alert("Ocurrió un error: " + textStatus);          // para reflejar los errores que no son controlados en el script, como errores de conexion
        });
    };

    $("#enviar").on('click', personasAlcanzadas);


});
