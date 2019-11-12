<div class="d-flex justify-content-between flex-wrap flex-md-nowrap r pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Añadir Prueba</h1>
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group mr-2">
      <a href="{$_WEB_PATH_}/user/pruebas/pruebas.php" class="btn btn-sm btn-outline-secondary" role="button"
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
    <h4 class="mb-3">Información de la prueba</h4>
    <form method="POST" class="needs-validation" novalidate>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Datos de la persona receptor@</th>
            <th>Población originaria</th>
            <th>Población</th>
            <th>Realizacion Prueba</th>
            <th>Consejeria Pre-prueba</th>
            <th>Consejeria Post-prueba</th>
            <th>Resultado Prueba</th>
            
          </tr>
        </thead>
        <tbody class="">
          <tr>
            <td class="col-md-3">     
              <input type="hidden" id="id_cedula_persona_receptora" name="id_cedula_persona_receptora" value="{$id_cedula_persona_receptora}" /> 
              <input type="text" class="form-control typeahead" id="id_cedula_persona_receptora_buscada" name="id_cedula_persona_receptora_buscada"
                value="{$id_cedula_persona_receptora_buscada}" placeholder="Cédula" />
              <small id="registroHelpBlock" class="form-text text-muted">
                Si la cédula ya existe, los campos población y pob. originaria se deshabilitarán
              </small>
            <!--
              <td class="col-md-3">
                <input type="hidden" id="id_cedula_persona_receptora" name="id_cedula_persona_receptora" value="{$id_cedula_persona_receptora}" /> 
                <input type="text" class="form-control typeahead" id="id_cedula_persona_receptora_buscada" name="id_cedula_persona_receptora_buscada"
                  value="{$id_cedula_persona_receptora_buscada}" placeholder="Cédula" />
                <small id="registroHelpBlock" class="form-text text-muted">
                  Si la cédula ya existe, los campos población y pob. originaria se deshabilitarán
                </small>
              </td>
            -->

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
            <td class="text-center col-md-1">
              <select class="custom-select d-block" id="realizacion_prueba" name="realizacion_prueba" required {if $id_cedula_persona_receptora ne '' } disabled {/if}> 
                  {html_options values=$realizacion_prueba output=$realizacion_prueba selected=$realizacion_prueba}
                </select>
            </td>
            <td class="text-center col-md-1">
              <input class="form-check-input" type="checkbox" id="consejeria_pre_prueba" name="consejeria_pre_prueba"
                {if $consejeria_pre_prueba ne ''} checked{/if} />
            </td>
            <td class="text-center col-md-1">
              <input class="form-check-input" type="checkbox" id="consejeria_post_prueba"
                name="consejeria_post_prueba" {if $consejeria_post_prueba ne ''} checked{/if} />
            </td>
            <td class="text-center col-md-1">
              <select class="custom-select d-block" id="resultado_prueba" name="resultado_prueba" required {if $id_cedula_persona_receptora ne '' } disabled {/if}> 
                  {html_options values=$resultados_posibles output=$resultados_posibles selected=$resultado_prueba}
                </select>
            </td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <th>Datos de la persona receptor@</th>   
            <th>Población originaria</th>
            <th>Población</th>   
            <th>Realizacion Prueba</th> 
            <th>Consejeria Pre-prueba</th>
            <th>Consejeria Post-prueba</th>
            <th>Resultado Prueba</th>
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