
var desde = document.getElementById("#from");         // Aqui quiero declarar las variables $desde y $hasta 
var hasta = document.getElementById("#to");           // y pensaba que se tienen que declarar asi


$(function() {
    var dateFormat = "yy/mm/dd",
      from = $( "#from" )                       
        .datepicker({
            showWeek: true,
            defaultDate: "-1m",
            changeMonth: true,
            numberOfMonths: 2,
            
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#to" ).datepicker({
            showWeek: true,
            defaultDate: "-1m",
            changeMonth: true,
            numberOfMonths: 2,
            
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }

  } );

$(function validarFechas(desde, hasta) { 
    

    if (desde>hasta){        

        return "La fecha de inical seleccionada, debe ser anterior a la fecha final"

    }

});

                            // Aqui entiendo que no se pueden pasar eso parametro, pero como se explican los parametros pues
$(document).ready(function( desde, hasta) {
  var table = $('#alcanzados').DataTable( {// plugin de jquery al que le das las colunas de una clase. llama al ajax
    "ajax": "ajax.php?funcion=getPersonasAlcanzadasByDate",
    "columns": [
        // La primera columna nos permitirá expandir para mostrar datos extra
        { "data": "id_cedula_persona_receptora" },                                    
        { "data": "poblacion" },
        { "data": "fecha" }       
                    // Ahora bien, si lo que yo quiero es desplegar una tabla
                    // en la que las columnas no son las que unciamente vienen
                    // en la tabla alcanzados... como lo haria??
                    // Ya que el campo de poblacion, esta en la tabla PersonaReceptora no en Alcanzados
        ],
        // Botones para exportar el listado
        dom: 'Bfrtip',
        "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
  },
});