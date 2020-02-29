/**
 * DataPiker nos facilita la eleccion de la fecha desde un calendario con funcionalidades 
 * que facilitan la insercion de datos y reduce la posibilidad de introducir datos erroneos
 */
$(document).ready(function() {
  var dateFormat = "dd/mm/yy";
  var desde = $( "#desde" )   //Jquery por eso se $
      .datepicker({
        defaultDate: "+1w",
        dateFormat: dateFormat,
        changeMonth: true,
        numberOfMonths: 2
      })
      .on( "change", function() {   // on es un listener
        hasta.datepicker( "option", "minDate", getDate( this ) );
      });
  var hasta = $( "#hasta" )
    .datepicker({
        defaultDate: "+1w",
        dateFormat: dateFormat,
        changeMonth: true,
        numberOfMonths: 2
    })
    .on( "change", function() {
      desde.datepicker( "option", "maxDate", getDate( this ) );
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

});

