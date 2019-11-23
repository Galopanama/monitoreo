<?php
/** The file constantes will ease the reference to the table's name by assigning constant names and 
 * reduce the time in case that table names change in the future */

class Constantes {

    const INDIVIDUAL = 'promotor_realiza_entrevista_individual';
    const GRUPAL = 'promotor_realiza_actividad_grupal_con_personas_receptoras';
    const PRUEBA = 'tecnologo_realiza_prueba_vih_a_persona_receptora';
    const USUARIO = 'usuario';
    const SUBRECEPTOR = 'subreceptor';
    const TECNOLOGO = 'tecnologo';
    const PROMOTOR = 'promotor';
    const PERSONA_RECEPTORA = 'persona_receptora';
    const ALCANZADOS = 'total_por_subreceptor';        //introducido para conseguir manipular esa vista 
} 
?>