<div class="d-flex justify-content-between flex-wrap flex-md-nowrap r pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Añadir entrevista individual</h1>
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group mr-2">
      <a href="{$_WEB_PATH_}/user/entrevistas/individuales.php" class="btn btn-sm btn-outline-secondary" role="button"
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

      <div class="form-row">
        <div class="col-auto">
          <label for="region_de_salud">Región de salud</label>
          <select class="custom-select d-block" id="region_de_salud" name="region_de_salud" required> 
            {html_options values=$regiones_de_salud output=$regiones_de_salud selected=$region_de_salud}
          </select>
        </div>
        <div class="col-auto">
          <label for="area">Área</label>
          <input type="text" class="form-control" id="area" name="area" placeholder="Área" value="{$area}" required>
          <small id="areaHelpBlock" class="form-text text-muted">
              Máx. 20 caracteres
            </small>
        </div>
      </div>

      <hr />

      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Persona receptora</th>
            <th>Población originaria</th>
            <th>Población</th>
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
            <td class="col-md-3">
              <input type="hidden" id="id_cedula_persona_receptora" name="id_cedula_persona_receptora" value="{$id_cedula_persona_receptora}" /> 
              <input type="text" class="form-control typeahead id_cedula_persona_receptora_buscada" id="id_cedula_persona_receptora_buscada" name="id_cedula_persona_receptora_buscada"
                value="{$id_cedula_persona_receptora_buscada}" placeholder="Cédula" />
              <small id="registroHelpBlock" class="form-text text-muted">
                Si la cédula ya existe, los campos población y pob. originaria se deshabilitarán
              </small>
            </td>
            <td class="col-md-1">
              <input class="form-check-input col-sm-10" type="checkbox" id="poblacion_originaria" name="poblacion_originaria"
                {if $poblacion_originaria ne ''} checked{/if} {if $id_cedula_persona_receptora ne '' } disabled {/if}/>
            </td>
            <td class="col-md-1">
              <select class="custom-select d-block" id="poblacion" name="poblacion" required {if $id_cedula_persona_receptora ne '' } disabled {/if}> 
                {html_options values=$tipos_poblacion_permitidos output=$tipos_poblacion_permitidos selected=$poblacion}
              </select>
            </td>
            <td class="col-md-1">
              <input type="number" class="form-control" id="condones_entregados" name="condones_entregados"
                value="{$condones_entregados}" min="0" required />
            </td>
            <td class="col-md-1">
              <input type="number" class="form-control" id="lubricantes_entregados" name="lubricantes_entregados"
                value="{$lubricantes_entregados}" min="0" required />
            </td>
            <td class="col-md-1">
              <input type="number" class="form-control" id="materiales_educativos_entregados"
                name="materiales_educativos_entregados" value="{$materiales_educativos_entregados}" min="0" required />
            </td>
            <td class="text-center col-md-1">
              <input class="form-check-input" type="checkbox" id="uso_del_condon" name="uso_del_condon"
                {if $uso_del_condon ne ''} checked{/if} />
            </td>
            <td class="text-center col-md-1">
              <input class="form-check-input" type="checkbox" id="uso_de_alcohol_y_drogas_ilicitas"
                name="uso_de_alcohol_y_drogas_ilicitas" {if $uso_de_alcohol_y_drogas_ilicitas ne ''} checked{/if} />
            </td>
            <td class="text-center col-md-1">
              <input class="form-check-input" type="checkbox" id="informacion_CLAM" name="informacion_CLAM"
                {if $informacion_CLAM ne ''} checked{/if} />
            </td>
            <td class="text-center col-md-1">
              <input class="form-check-input" type="checkbox" id="referencia_a_prueba_de_VIH"
                name="referencia_a_prueba_de_VIH" {if $referencia_a_prueba_de_VIH ne ''} checked{/if} />
            </td>
            <td class="text-center col-md-1">
              <input class="form-check-input" type="checkbox" id="referencia_a_clinica_TB"
                name="referencia_a_clinica_TB" {if $referencia_a_clinica_TB ne ''} checked{/if} />
            </td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
              <th>Persona receptora</th>
              <th>Población originaria</th>
              <th>Población</th>
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