<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">{$titulo}</h1>
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group mr-2">
      <a href="{$_WEB_PATH_}/admin/usuarios/index.php" class="btn btn-sm btn-outline-secondary" role="button" aria-pressed="true">Cancelar y volver</a>
    </div>
  </div>
</div>

<div class="alert alert-danger d-none" role="alert">
  <ul>
    {foreach $errores as $error}
      <li>{$error}</li>
    {/foreach}
  </ul>
</div>

<form method="POST">
  <input type="hidden" name="id_usuario" value="{$id_usuario}" />

  <div class="row">
    <div class="col-md-8 order-md-1">
      <h4 class="mb-3">Información personal</h4>
      <form class="needs-validation" novalidate>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="" value="{$nombre}" required>
            <div class="invalid-feedback">
              El nombre es obligatorio.
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="apellidos">Apellidos</label>
            <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="" value="{$apellidos}" required>
            <div class="invalid-feedback">
              El apellido es obligatorio
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label for="login">Login (username):</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">@</span>
            </div>
            <input type="text" class="form-control" id="login" name="login" value="{$login}" placeholder="Username" required {if $id_usuario ne '' } disabled {/if}> 
            <div class="invalid-feedback" style="width: 100%;">
              El campo login es obligatorio, y debe ser único en el sistema.
            </div>
          </div>
        </div>

    <div class="row">
      <div class="col-md-6 mb-3">
        <label for="password">Contraseña</label>
        <input type="password" autocomplete="off" class="form-control" id="password" name="password" placeholder="Contraseña" value="" {if $id_usuario eq '' } required {/if}>
        <small id="passwordHelpBlock" class="form-text text-muted">
          {if $id_usuario ne '' } Deje el campo en blanco si no desea actualizar la contraseña del usuario <br/> {/if}La contraseña debe tener entre 8 y 16 caracteres y no puede contener espacios, caracteres especiales o emojis.
        </small>
        <div class="invalid-feedback">
          La contraseña es obligatoria (8 a 16 caracteres sin espacios)
        </div>
      </div>
      <div class="col-md-6 mb-3">
        <label for="password_confirm">Confirme contraseña</label>
        <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="" value="" {if $id_usuario eq '' } required {/if}>
      </div>
    </div>

    <div class="mb-3">
      <label for="telefono">Número de teléfono</label>
      <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="XXX-XXXX" value="{$telefono}" required>
      <div class="invalid-feedback">
        El número de teléfono es obligatorio
      </div>
    </div>

    <div class="row">
      <div class="col-md-5 mb-3">
        <label for="tipo_de_usuario">Tipo de usuario</label>
        <select class="custom-select d-block w-100" id="tipo_de_usuario" name="tipo_de_usuario" required {if $id_usuario ne '' } disabled {/if}> 
          {html_options values=$tipos_de_usuario output=$tipos_de_usuario|capitalize selected=$tipo_de_usuario}
        </select> 
        <div class="invalid-feedback">
          Por favor, selecciona un tipo de usuario válido.
        </div>
      </div>
    </div>

    <div class="mb-3 subreceptor tipo_hidden d-none">
      <label for="ubicacion">Ubicación:</label>
      <input type="text" class="form-control" id="ubicacion" name="ubicacion" value="{$ubicacion}" placeholder="Ubicacion"> 
    </div>
    <div class="row tecnologo tipo_hidden d-none">
      <div class="col-md-6 mb-3">
        <label for="numero_de_registro">Número de registro:</label>
        <input type="text" class="form-control" id="numero_de_registro" name="numero_de_registro" value="{$numero_de_registro}" placeholder="Número de registro"> 
        <small id="registroHelpBlock" class="form-text text-muted">
          Introduce sólo números
        </small>
      </div>
      {* <div class="col-md-6 mb-3">
        <label for="id_cedula">Cédula:</label>
        <input type="text" class="form-control" id="id_cedula" name="id_cedula" value="{$id_cedula}" placeholder="Cédula"> 
      </div> *}
    </div>

    <div class="promotor tipo_hidden d-none">
      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="id_cedula">Cédula:</label>
          <input type="text" class="form-control" id="id_cedula" name="id_cedula" value="{$id_cedula}" placeholder="Cédula">
        </div>
        <div class="col-md-6 mb-3">
          <label for="organizacion">Organización:</label>
          <input type="text" class="form-control" id="organizacion" name="organizacion" value="{$organizacion}" placeholder="Organización"> 
        </div>
      </div>

      <div class="mb-3">
        <label for="id_cedula">Subreceptor:</label>
        <input type="text" class="form-control typeahead" id="search_subreceptor" name="search_subreceptor" 
          value="{$search_subreceptor}" placeholder="Introduce login, nombre, apellidos o ubicación para buscar" {if $id_usuario ne '' } readonly {/if}>
        <input type="hidden" name="id_subreceptor" id="id_subreceptor" value="{$id_subreceptor}" />
      </div>
    </div>

  <hr class="mb-4">
  <button class="btn btn-primary btn-lg btn-block" type="submit">Enviar</button>
</form>
</div>
</div>



</form>