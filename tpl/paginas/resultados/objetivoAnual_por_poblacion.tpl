<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Personas Alcanzadas </h1>
  <div class="btn-toolbar mb-2 mb-md-0">
  </div>
</div>

<div class="alert alert-danger d-none" role="alert">
  <p>{$error}</p>
</div>

<div class="alert alert-success d-none" role="alert">
  <h4 class="alert-heading">{$exito_titulo}</h4>
  <p>{$exito_mensaje}</p>
</div>



<form id="formulario" action= 'ajax.php' method="POST"> 
<input type="hidden" name="funcion" value="getPersonasAlcanzadas">
<div>                               
  <h3>ELIGE UN TIPO DE GRAFICA</h3>
  <input type="radio" name="grafica" id="bar" value="bar">
  <label for="bar">Barra</label><br>
  <input type="radio" name="grafica" id="pie" value="pie">
  <label for="pie">Pie</label><br>
  <br>
</div>
<div>
  <h3>ELIGE UNA POBLACION PARA LA VISUALIZACION</h3>
</div>
<div>
  <h4>LA POBLACION CLAVE</h4>
    <input type="checkbox" class="poblacion" name="poblacion[]" id="HSH" value="HSH">
    <label for="HSH">HSH</label><br>
    <input type="checkbox" class="poblacion" name="poblacion[]" id="TSF" value="TSF">
    <label for="TSF">TSF</label><br>
    <input type="checkbox" class="poblacion" name="poblacion[]" id="TRANS" value="TRANS">
    <label for="TRANS">TRANS</label><br>
</div>

  <br>
  

</form>

<input type="button" name="boton" id="enviar" value="Envia la selección"><br>

