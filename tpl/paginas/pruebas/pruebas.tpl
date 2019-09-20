<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Prueba</h1>
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group mr-2">
    {if $tipo_usuario eq 'tecnologo'}
      <a href="{$_WEB_PATH_}/user/pruebas/addPrueba.php" class="btn btn-sm btn-outline-secondary" role="button"
        aria-pressed="true">Añadir Prueba</a>
    {/if}
    </div>
  </div>
</div>

<div class="alert alert-danger d-none" role="alert">
  <p>{$error}</p>
</div>

<div class="alert alert-success d-none" role="alert">
  <h4 class="alert-heading">{$exito_titulo}</h4>
  <p>{$exito_mensaje}</p>
</div>

<table id="pruebas" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Datos receptor/a</th>
            <th>Tecnologo</th>
            <th>Fecha</th>
            <th>Realizacion Prueba</th>
            <th>Consejeria Pre-prueba</th>
            <th>Consejeria Post-prueba</th>
            <th>Resultado Prueba</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>Datos receptor/a</th>
            <th>Tecnologo</th>
            <th>Fecha</th>
            <th>Realizacion Prueba</th>
            <th>Consejeria Pre-prueba</th>
            <th>Consejeria Post-prueba</th>
            <th>Resultado Prueba</th>
        </tr>
    </tfoot>
</table>
