<?php
/**
 * This file returns all the interviews from the individuals and groups 
 * The information can it can be searched by the organisantions' name as well as just the name of the Promotor
 */
require_once __DIR__ . '/../../config/config.php';
// Restringimos el acceso sólo a usuarios subreceptores
// it is only permited the access to the user 'subreceptor'
$perfiles_aceptados = array('subreceptor');
require_once __DIR__ . '/../../security/autorizador.php';
// Llama a los siguientes archivos del Modelo
// Call the files from the Model
require_once __DIR__ . '/../../src/Usuarios.php';
require_once __DIR__ . '/../../src/PersonasAlcanzadas.php';


//the user can retrieve the information of all the interviews. 
//The information return as an Json object

switch($_POST['funcion']){
    case "getPersonasAlcanzadas":
        echo json_encode(getPersonasAlcanzadas());
        exit;
    case "getPruebasRealizadas":
        echo json_encode(getPruebasRealizadas());
        exit;
    default:
        exit;
}


/** Devuelve la informacion de las PersonasAlcanzadas
 * que vamos a utilizar para llevar a los graficos
 */
function getPersonasAlcanzadas() {
    $personas = PersonasAlcanzadas::getPersonasAlcanzadasFiltradas($_POST['filtro']);
    return ($personas);   
}


/** devuleve al informacion de las PurebasRealizadas
 * que vamos a utlizar para llevar a los graficos
 */

// AUN ESTA POR DESARROLLAR 

// function getPruebasRealizadas() {

// }







