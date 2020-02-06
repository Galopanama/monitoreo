/** pretendo que se vayan habilitando los campos del formulario a medida que los usuarios
 * vayan rellenando el formulario
 * Finalmente si todos los campos tienen al menos un elementos seleccionado, se activaria el boton de 
 * Submit
 */

function habilitar()
    {
        var grafica = document.getElementsByName("grafica");
        var poblacion = document.getElementsByName ("poblacion");
        var fecha = document.getElementsByName ("fecha");
        var regiones = document.getElementsByName ("regiones");
        var boton = document.getElementsByName ("boton")

        if (grafica.value == null)
        {
            poblacion.disable = true;
            fecha.disable = true;
            regiones = true;
        } 
        else if (poblacion.value == null)
        {
            fecha.disable = true;
            regiones.disable = true;
        }
        else if (fecha.value == null)
        {
            regiones.disable = true;
        }
        else 
        {
            boton.disable = false;
        }
   
    }
