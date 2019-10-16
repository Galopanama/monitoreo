<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Alcanzados</h1>
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group mr-2">
    {if $tipo_usuario eq 'promotor'}
      <a href="{$_WEB_PATH_}/user/entrevistas/addIndividual.php" class="btn btn-sm btn-outline-secondary" role="button"
        aria-pressed="true">Añadir Individual</a>
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

<table id="totales_entregados" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Datos receptor/a</th>
            <th>Total de condones entregados</th>
            <th>Total de lubricantes entregados</th>
            <th>Total de materiales educativos entregados</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>Datos receptor/a</th>
            <th>Total de condones entregados</th>
            <th>Total de lubricantes entregados</th>
            <th>Total de materiales educativos entregados</th>
        </tr>
    </tfoot>
</table>
