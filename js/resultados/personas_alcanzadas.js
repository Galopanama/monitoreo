/** 
 * Desde este fichero vamos a traducir del formualrio a la grafica 
 */

$(document).ready(function() {    
    function personasAlcanzadas(){

        // Las dos variable a continuacion van a facilitar la recogida de informacion de las poblaciones y regiones de salud selecionadas
        let poblacion = 
            $('input[name="poblacion[]"]:checked').map(function(_, el) {    
                return $(el).val();                                         
            }).get();

        let regiones =
            $('input[name="regiones[]"]:checked').map(function(_, el){
                return $(el).val();
            }).get();

        // Desde aqui se realiza la recogida y tratamiento de las variables 
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
        
        // organizaciones de la respuesta y la parte visual para la representacion gráfica
        request.done(function (response) {
           
            let poblaciones = {};
            poblaciones["TSF"] = {
                backgroundColor: "#ff0000",
                borderColor: "#000",
                borderWidth:1,
                data: []
            };
            poblaciones["HSH"] = {
                backgroundColor: "#33ccff",
                borderColor: "#000",
                borderWidth:1,
                data: []
            };
            poblaciones["TRANS"] = {
                backgroundColor: "#ff66cc",
                borderColor: "#000",
                borderWidth:1,
                data: []
            };

            // Guarda sólo una vez el nombre de las regiones que tengan datos
            let nombre_regiones = [];

            // Recorremos la respuesta y guardamos los datos
            response.forEach(function(resultado){

                poblaciones[resultado.poblacion]["data"][resultado.region_de_salud] = resultado.Total_de_Personas_Alcanzadas;

                if (nombre_regiones.indexOf(resultado.region_de_salud) == -1){
                    // Si la region no existe, la añadimos a una lista
                    nombre_regiones.push(resultado.region_de_salud);
                }
            });

            // Creo un array donde voy a guardar las distintas poblaciones que formarán la gráfica
            // Cada población es en realidad un objeto con unas propiedades.
            // En este caso, hemos creado el objeto poblaciones de tal forma que cada una de sus propiedades
            // se corresponda con la propiedad que espera la gráfica
            dataset = [];
            // Con entries obtenemos todas las propiedades de un objeto en un pequeño array:
            // en el elemento 0 del array estará la key y en el elemento 1 el valor
            arrayPoblaciones = Object.entries(poblaciones);

            // Recorremos cada una de las poblaciones
            arrayPoblaciones.forEach(function (elem){
                // Ya que utilizamos la misma estructura al crear nuestro objeto de poblaciones que las que necesita la gráfica
                // vamos a aprovecharlo, y cogemos de base nuestro propio objeto
                let poblacion = elem[1];
                // Como decíamos, el label viene en el 0
                poblacion.label = elem[0];

                /*
                Esta es quizás la propiedad más compleja. Hemos sustituido la propiedad data por una función que 
                lo que hará será recorrer el array de nombres, y por cada una de esas regiones de salud, obtendrá
                el número de alcanzados para esa población y esa región en concreto
                */
                poblacion.data = nombre_regiones.map(function(region){
                    return elem[1]["data"][region]?elem[1]["data"][region]:0;
                    // La línea anterior equivale a lo siguiente:
                    // if (elem[1]["data"][region]){
                    //     return elem[1]["data"][region];
                    // }
                    // else return 0;
                });
                /*data = {
                    label: elem[0],
                    // recorrer el array de nombre regiones para generar un array con el número de alcanzados de dichas regiones
                    // para esta poblacion
                    data: nombre_regiones.map(function(region){
                        return elem[1]["data"][region]?elem[1]["data"][region]:0;
                    }),
                    backgroundColor: "#ff0000",
                    borderWidth:1,
                    borderColor: '#000000'
                };*/
                // Una vez que ya tenemos la estructura necesaria para dicha población, la añadimos al array, que será lo que
                // usaremos en la gráfica para representar las variables
                dataset.push(poblacion);
            });


            function ChartIt(){

                    const ctx = document.getElementById("canvas");
                    let myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {   
                            labels: nombre_regiones.map(function(region){
                                return region.replace(/_/g, " ");
                            }),
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
            // llamada a la funcion Chartit que esta definida en las lineas anteriores
            ChartIt();


        }); 
    

        request.fail(function (jqXHR, textStatus) {
            alert("Ocurrió un error: " + textStatus);          // para reflejar los errores que no son controlados en el script, como errores de conexion
        });

    }
    

    $("#enviar").on('click', personasAlcanzadas);


});
