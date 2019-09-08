<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Entrevistas grupales</h1>
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group mr-2">
      {if $tipo_usuario eq 'promotor'}
        <a href="{$_WEB_PATH_}/user/entrevistas/addGrupal.php" class="btn btn-sm btn-outline-secondary" role="button"
          aria-pressed="true">Añadir Grupal</a>
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

<table id="entrevistasGrupales" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Datos receptor/a</th>
            <th>Promotor</th>
            <th>Fecha</th>
            <th>Región</th>
            <th>Área</th>
            <th>Condones entregados</th>
            <th>Lubricantes entregados</th>
            <th>Materiales educativos entregados</th>
            <th>Estilos autocuidado</th>
            <th>Estigma discriminación</th>
            <th>Uso del condón</th>
            <th>Salud sexual e ITS</th>
            <th>Ofrecimiento prueba VIH</th>
            <th>CLAM</th>
            <th>Salud anal</th>
            <th>Hormonización</th>
            <th>Apoyo y ori. psicológico</th>
            <th>Diversidad sexual</th>
            <th>Tuberculosis y coinfecciones</th>
            <th>Infec. oportunistas</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>Datos receptor/a</th>
            <th>Promotor</th>
            <th>Fecha</th>
            <th>Región</th>
            <th>Área</th>
            <th>Condones entregados</th>
            <th>Lubricantes entregados</th>
            <th>Materiales educativos entregados</th>
            <th>Estilos autocuidado</th>
            <th>Estigma discriminación</th>
            <th>Uso del condón</th>
            <th>Salud sexual e ITS</th>
            <th>Ofrecimiento prueba VIH</th>
            <th>CLAM</th>
            <th>Salud anal</th>
            <th>Hormonización</th>
            <th>Apoyo y ori. psicológico</th>
            <th>Diversidad sexual</th>
            <th>Tuberculosis y coinfecciones</th>
            <th>Infec. oportunistas</th>
        </tr>
    </tfoot>
</table>
