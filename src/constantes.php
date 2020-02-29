<?php
/** 
 * La clase de Constantes se crea para facilitar las peticiones a la base de datos.
 * Reduce las lineas de las peticiones a la base de datos y resulta mas facil de mantener
 */

class Constantes {

    const INDIVIDUAL = 'promotor_realiza_entrevista_individual';
    const GRUPAL = 'promotor_realiza_actividad_grupal_con_personas_receptoras';
    const PRUEBA = 'tecnologo_realiza_prueba_vih_a_persona_receptora';
    const USUARIO = 'usuario';
    const SUBRECEPTOR = 'subreceptor';
    const TECNOLOGO = 'tecnologo';
    const PROMOTOR = 'promotor';
    const PERSONA_RECEPTORA = 'persona_receptora';
    const ALCANZADOS = 'alcanzados';        //introducido para conseguir manipular esa vista 
} 
?>