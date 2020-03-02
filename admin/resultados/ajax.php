<?php
/**
 * Este fichero devuelve la informacion de las Personas Alcanzadas al Adinsitrador 
 * Y puede alojar la funcion que devuelva los resultados de las Pruebas  
 */
require_once __DIR__ . '/../../config/config.php';
// Restringimos el acceso sólo a usuarios administrador
$perfiles_aceptados = array('administrador');
require_once __DIR__ . '/../../security/autorizador.php';

// Llama a los siguientes archivos del Modelo
require_once __DIR__ . '/../../src/Usuarios.php';
require_once __DIR__ . '/../../src/PersonasAlcanzadas.php';


// El usuario recupera la informacion de las personas Alcanzadas 
// La informacion se devuelve en un objeto JSon
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


/** 
 * Devuelve la informacion de las PersonasAlcanzadas
 * que vamos a utilizar para llevar a los graficos
 */
function getPersonasAlcanzadas() {
    $personas = PersonasAlcanzadas::getPersonasAlcanzadasFiltradas($_POST['filtro']);
    return ($personas);   
}

/** 
 * devuleve al informacion de las PurebasRealizadas
 * que vamos a utlizar para llevar a los graficos
 */

// AUN ESTA POR DESARROLLAR 

// function getPruebasRealizadas() {

// }
