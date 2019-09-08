<div class="d-flex justify-content-between flex-wrap flex-md-nowrap r pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Añadir entrevista grupal</h1>
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group mr-2">
      <a href="{$_WEB_PATH_}/user/entrevistas/grupales.php" class="btn btn-sm btn-outline-secondary" role="button"
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
            <th>Estilos de autocuidado</th>
            <th>DDHH Estigma Discrim.</th>
            <th>Uso correcto y constante del condón</th>
            <th>Salud sexual e ITS</th>
            <th>Ofrecimiento y ref. a prueba VIH</th>
            <th>CLAM y otros servicios</th>
            <th>Salud anal</th>
            <th>Hormonización</th>
            <th>Apoyo y orientación psicologica</th>
            <th>Diversidad sexual e identidad expresión de género</th>
            <th>Tuberculosis y coinfecciones</th>
            <th>Infecciones oportunistas</th>
          </tr>
        </thead>
        <tbody class="">
          {for $index=1 to $numero_filas_mostrar}
          <tr>
            <td class="col-md-15">
              <input type="hidden" id="id_persona_receptora_{$index}" name="id_persona_receptora_{$index}" value="{$valores[$index]['id_persona_receptora']}" /> 
              <input type="text" class="form-control typeahead id_persona_receptora_buscada" id="id_persona_receptora_buscada_{$index}" name="id_persona_receptora_buscada_{$index}"
                value="{$valores[$index]['id_persona_receptora_buscada']}" placeholder="Cédula" {if $index eq 1}required{/if} />
                {if $index eq 1}
                  <small id="registroHelpBlock" class="form-text text-muted">
                    Si la cédula ya existe, los campos población y pob. originaria se deshabilitarán
                  </small>
                {/if}
            </td>
            <td class="col-md-1">
              <input class="form-check-input col-sm-10" type="checkbox" id="poblacion_originaria_{$index}" name="poblacion_originaria_{$index}"
                {if $valores[$index]['poblacion_originaria'] ne ''} checked{/if} {if $valores[$index]['id_persona_receptora'] ne '' } disabled {/if}/>
            </td>
            <td class="col-md-1">
              <select class="custom-select d-block" id="poblacion_{$index}" name="poblacion_{$index}" {if $index eq 1}required{/if} {if $valores[$index]['id_persona_receptora'] ne '' } disabled {/if}> 
                {html_options values=$tipos_poblacion_permitidos output=$tipos_poblacion_permitidos selected=$valores[$index]['poblacion']}
              </select>
            </td>
            <td class="col-md-1">
              <input type="number" class="form-control" id="condones_entregados_{$index}" name="condones_entregados_{$index}"
                value="{$valores[$index]['condones_entregados']}" min="0" {if $index eq 1}required{/if} />
            </td>
            <td class="col-md-1">
              <input type="number" class="form-control" id="lubricantes_entregados_{$index}" name="lubricantes_entregados_{$index}"
                value="{$valores[$index]['lubricantes_entregados']}" min="0" {if $index eq 1}required{/if} />
            </td>
            <td class="col-md-1">
              <input type="number" class="form-control" id="materiales_educativos_entregados_{$index}"
                name="materiales_educativos_entregados_{$index}" value="{$valores[$index]['materiales_educativos_entregados']}" min="0" {if $index eq 1}required{/if} />
            </td>
            <td class="text-center col-md-1">
              <input class="form-check-input" type="checkbox" id="estilos_autocuidado_{$index}" name="estilos_autocuidado_{$index}"
                {if $valores[$index]['estilos_autocuidado'] ne ''} checked{/if} />
            </td>
            <td class="text-center col-md-1">
              <input class="form-check-input" type="checkbox" id="ddhh_estigma_discriminacion_{$index}"
                name="ddhh_estigma_discriminacion_{$index}" {if $valores[$index]['ddhh_estigma_discriminacion'] ne ''} checked{/if} />
            </td>
            <td class="text-center col-md-1">
              <input class="form-check-input" type="checkbox" id="uso_correcto_y_constantes_del_condon_{$index}" name="uso_correcto_y_constantes_del_condon_{$index}"
                {if $valores[$index]['uso_correcto_y_constantes_del_condon'] ne ''} checked{/if} />
            </td>
            <td class="text-center col-md-1">
              <input class="form-check-input" type="checkbox" id="salud_sexual_e_ITS_{$index}"
                name="salud_sexual_e_ITS_{$index}" {if $valores[$index]['salud_sexual_e_ITS'] ne ''} checked{/if} />
            </td>
            <td class="text-center col-md-1">
              <input class="form-check-input" type="checkbox" id="ofrecimiento_y_referencia_a_la_prueba_de_VIH_{$index}"
                name="ofrecimiento_y_referencia_a_la_prueba_de_VIH_{$index}" {if $valores[$index]['ofrecimiento_y_referencia_a_la_prueba_de_VIH'] ne ''} checked{/if} />
            </td>
            <td class="text-center col-md-1">
              <input class="form-check-input" type="checkbox" id="CLAM_y_otros_servicios_{$index}" name="CLAM_y_otros_servicios_{$index}"
                {if $valores[$index]['CLAM_y_otros_servicios'] ne ''} checked{/if} />
            </td>
            <td class="text-center col-md-1">
              <input class="form-check-input" type="checkbox" id="salud_anal_{$index}" name="salud_anal_{$index}"
                {if $valores[$index]['salud_anal'] ne ''} checked{/if} />
            </td>
            <td class="text-center col-md-1">
                <input class="form-check-input" type="checkbox" id="hormonizacion_{$index}" name="hormonizacion_{$index}"
                  {if $valores[$index]['hormonizacion'] ne ''} checked{/if} />
              </td>
            <td class="text-center col-md-1">
                <input class="form-check-input" type="checkbox" id="apoyo_y_orientacion_psicologico_{$index}" name="apoyo_y_orientacion_psicologico_{$index}"
                  {if $valores[$index]['apoyo_y_orientacion_psicologico'] ne ''} checked{/if} />
              </td>
            <td class="text-center col-md-1">
                <input class="form-check-input" type="checkbox" id="diversidad_sexual_identidad_expresion_de_genero_{$index}" name="diversidad_sexual_identidad_expresion_de_genero_{$index}"
                  {if $valores[$index]['diversidad_sexual_identidad_expresion_de_genero'] ne ''} checked{/if} />
              </td>
            <td class="text-center col-md-1">
                <input class="form-check-input" type="checkbox" id="tuberculosis_y_coinfecciones_{$index}" name="tuberculosis_y_coinfecciones_{$index}"
                  {if $valores[$index]['tuberculosis_y_coinfecciones'] ne ''} checked{/if} />
              </td>
            <td class="text-center col-md-1">
                <input class="form-check-input" type="checkbox" id="infecciones_oportunistas_{$index}" name="infecciones_oportunistas_{$index}"
                  {if $valores[$index]['infecciones_oportunistas'] ne ''} checked{/if} />
              </td>
          </tr>
          {/for}
        </tbody>
        <tfoot>
          <tr>
              <th>Persona receptora</th>
              <th>Población originaria</th>
              <th>Población</th>
              <th>Condones entregados</th>
              <th>Lubricantes entregados</th>
              <th>Materiales educativos entregados</th>
              <th>Estilos de autocuidado</th>
              <th>DDHH Estigma Discrim.</th>
              <th>Uso correcto y constante del condón</th>
              <th>Salud sexual e ITS</th>
              <th>Ofrecimiento y ref. a prueba VIH</th>
              <th>CLAM y otros servicios</th>
              <th>Salud anal</th>
              <th>Hormonización</th>
              <th>Apoyo y orientación psicologica</th>
              <th>Diversidad sexual e identidad expresión de género</th>
              <th>Tuberculosis y coinfecciones</th>
              <th>Infecciones oportunistas</th>
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