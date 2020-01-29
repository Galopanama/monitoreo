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
{* <div>                               
  <h3>ELIGE UN TIPO DE GRAFICA</h3>
  <input type="radio" name="grafica" id="bar" value="bar">
  <label for="bar">Barra</label><br>
  <input type="radio" name="grafica" id="pie" value="pie">
  <label for="pie">Pie</label><br>
  <br>
</div> *}
<div>
  <h3>ELIGE UN FILTRO PARA LA VISUALIZACION</h3>
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
<div>
  <h4>LA FECHA</h4>
    <label for="desde">Desde</label>
    <input type="text" name="desde" id="desde">
    <label for="hasta">Hasta</label>
    <input type="text" name="hasta" id="hasta" >
</div>
<div>
  <h4>LA REGION/ES DE SALUD</h4>
    <h6>Mostrara las regiones marchadas</h6>
    <input type="checkbox" name="regiones[]" id="Bocas_del_Toro" value="Bocas_del_Toro">Bocas del Toro<br>
    <input type="checkbox" name="regiones[]" id="Chiriquí" value="Chiriquí">Chiriquí<br> 
    <input type="checkbox" name="regiones[]" id="Coclé" value="Coclé">Coclé<br> 
    <input type="checkbox" name="regiones[]" id="Colón" value="Colón">Colón<br> 
    <input type="checkbox" name="regiones[]" id="Herrera" value="Herrera" >Herrera<br> 
    <input type="checkbox" name="regiones[]" id="Los_Santos" value="Los_Santos">Los Santos<br> 
    <input type="checkbox" name="regiones[]" id="Panamá_Metro" value="Panamá_Metro">Panamá Metro<br> 
    <input type="checkbox" name="regiones[]" id="Panamá_Oeste_1" value="Panamá_Oeste_1">Panamá Oeste 1<br> 
    <input type="checkbox" name="regiones[]" id="Panamá_Oeste_2" value="Panamá_Oeste_2">Panamá Oeste 2<br>
    <input type="checkbox" name="regiones[]" id="San_Miguelito" value="San_Miguelito">San Miguelito<br>
    <input type="checkbox" name="regiones[]" id="Veraguas" value="Veraguas">Veraguas<br>
</div>
  <br>
  

</form>

<input type="button" name="boton" id="enviar" value="Envia la selección"><br>

