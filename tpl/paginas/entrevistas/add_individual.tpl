<div class="d-flex justify-content-between flex-wrap flex-md-nowrap r pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Añadir entrevista individual</h1>
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group mr-2">
      <a href="{$_WEB_PATH_}/user/index.php" class="btn btn-sm btn-outline-secondary" role="button"
        aria-pressed="true">Cancelar y volver</a>
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


<div class="row">
  <div class="container-fluid">
    <h4 class="mb-3">Información de la entrevista</h4>
    <form method="POST" class="needs-validation" novalidate>
      <table class="table">
        <thead>
          <tr>
            <th>Persona receptora</th>
            <th>Condones entregados</th>
            <th>Lubricantes entregados</th>
            <th>Materiales educativos entregados</th>
            <th>Uso del condón</th>
            <th>Uso del alcohol y drogas ilícitas</th>
            <th>CLAM</th>
            <th>Ref. a pruebas VIH</th>
            <th>Ref. a clínica</th>
          </tr>
        </thead>
        <tbody class="">
          <tr>
            <td>
              <input type="text" class="form-control typeahead" id="search_receptora" name="search_receptora"
                value="{$search_receptora}" placeholder="Introduce login, nombre, apellidos o ubicación para buscar" />
              <input type="hidden" name="id_persona_receptora" id="id_persona_receptora"
                value="{$id_persona_receptora}" />
            </td>
            <td>
              <input type="number" class="form-control" id="condones_entregados" name="condones_entregados"
                value="{$condones_entregados}" min="0" required />
            </td>
            <td>
              <input type="number" class="form-control" id="lubricantes_entregados" name="lubricantes_entregados"
                value="{$lubricantes_entregados}" min="0" required />
            </td>
            <td>
              <input type="number" class="form-control" id="materiales_educativos_entregados"
                name="materiales_educativos_entregados" value="{$materiales_educativos_entregados}" min="0" required />
            </td>
            <td class="text-center">
              <input class="form-check-input" type="checkbox" id="uso_del_condon" name="uso_del_condon"
                value="{$uso_del_condon}" />
            </td>
            <td class="text-center">
              <input class="form-check-input" type="checkbox" id="uso_de_alcohol_y_drogas_ilicitas"
                name="uso_de_alcohol_y_drogas_ilicitas" value="{$uso_de_alcohol_y_drogas_ilicitas}" />
            </td>
            <td class="text-center">
              <input class="form-check-input" type="checkbox" id="informacion_CLAM" name="informacion_CLAM"
                value="{$informacion_CLAM}" />
            </td>
            <td class="text-center">
              <input class="form-check-input" type="checkbox" id="referencia_a_prueba_de_VIH"
                name="referencia_a_prueba_de_VIH" value="{$referencia_a_prueba_de_VIH}" />
            </td>
            <td class="text-center">
              <input class="form-check-input" type="checkbox" id="referencia_a_clinica_TB"
                name="referencia_a_clinica_TB" value="{$referencia_a_clinica_TB}" />
            </td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <th>Persona receptora</th>
            <th>Condones entregados</th>
            <th>Lubricantes entregados</th>
            <th>Materiales educativos entregados</th>
            <th>Uso del condón</th>
            <th>Uso del alcohol y drogas ilícitas</th>
            <th>CLAM</th>
            <th>Ref. a pruebas VIH</th>
            <th>Ref. a clínica</th>
          </tr>
      </tfoot>
      </table>

      <hr class="mb-4" />
      <button class="btn btn-primary btn-lg btn-block" type="submit">
        Enviar
      </button>
    </form>
  </div>
</div>