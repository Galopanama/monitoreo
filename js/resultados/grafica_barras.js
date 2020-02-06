

$(document).ready(function() {

    const REGIONES_DE_SALUD = Array("Bocas_del_Toro", "Chiriquí", "Coclé", "Colón", "Herrera", "Los_Santos", "Panamá_Metro", "Panamá_Oeste_1", "Panamá_Oeste_2", "San_Miguelito", "Veraguas");

    var ctx = document.getElementById("canvas");

    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {   
            labels: REGIONES_DE_SALUD,
            datasets: [  // cada uno de las poblaciones va a tener un barra que lo represente
                {                               // y esta se recoje en la siguiente propiedad y dentro de parentesis
                label: "TSF",
                data: [1,1,1],
                backgroundColor: "#ff0000",
                borderWidth:1,
                borderColor: '#000000'                
                },
                {
                label: "HSH",                          
                data: [3,2,3],                        
                backgroundColor: "#33ccff",
                borderWidth:1,
                borderColor: '#000000',                
                },
                {
                label: "TRANS",
                data: [1,3,5],
                backgroundColor: "#ff66cc",
                borderWidth:1,
                borderColor: '#000000'
                }
            ]
            },
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
    })

});


