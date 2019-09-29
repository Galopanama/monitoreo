<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Usuarios</h1>
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group mr-2">
      <a href="{$_WEB_PATH_}/admin/usuarios/add.php" class="btn btn-sm btn-outline-secondary" role="button" aria-pressed="true">Añadir usuario</a>
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

<div class="form-group mb-2 float-right">
  <input class="form-check-input" type="checkbox" id="mostrar_inactivos"/>
  <label class="form-check-label" for="mostrar_inactivos">Mostrar usuarios inactivos</label>
</div>
<table id="usuarios" class="display" style="width:100%">
    <thead>
        <tr>
            <th></th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Login</th>
            <th>Tipo de usuario</th>
            <th>Teléfono</th>
            <th>Activo</th>
            <th>Activar/Desactivar</th>
            <th>Editar</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th></th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Login</th>
            <th>Tipo de usuario</th>
            <th>Teléfono</th>
            <th>Activo</th>
            <th>Activar/Desactivar</th>
            <th>Editar</th>
        </tr>
    </tfoot>
</table>
