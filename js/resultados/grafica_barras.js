
$(document).ready(function() {

    var request = $.ajax({
        url: "ajax.php",
        method: "GET",
        success: function(personas) {
            console.log(personas);
        },
        error: function (personas){
            console.log(personas);
        }


    // function dibujarChart(resultados)

    // var poblacion = [];
    // var resultado = [];

    // for (var in data) {
    //     poblacion.push("Poblacion" = data[i].nombrepoblacion);
    //     resultado.push(data[i].resultado);
    // }

    // var chartdata = {
    //     labels: poblacion,
    //     datasets: [
    //         {
    //             label: "Total de Alcanzados",
    //             backgroundColor: "rgba(200, 200, 200, 0.75)",
    //             borderColor: "rgba(200, 200, 200, 0.75)",
    //             hoverBackgroundColor: "rgba(200, 200, 200, 1)",
    //             hoverBorderColor: "rgba(200, 200, 200, 1)",
    //             data: resultado 
    //         }
    //     ]
    // };

    // var ctx = $("#canvas");

    // var barGraph = new Chart(ctx, {
    //     type: 'bar',
    //     data: chartdata
    // });
});


