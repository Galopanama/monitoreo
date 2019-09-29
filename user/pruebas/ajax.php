<?php
/**
 * This file returns all the pruebas from the pruebas
 * The information can it can be searched by the organisantions' name as well as just the name of the Tecnologo
 */
require_once __DIR__ . '/../../config/config.php';
// Restringimos el acceso sólo a usuarios tecnologos y subreceptores
// it is only permited the access to the user 'tecnologo' and 'subreceptor'
$perfiles_aceptados = array('tecnologo','subreceptor');
require_once __DIR__ . '/../../security/autorizador.php';
// Call the files from the Model
require_once __DIR__ . '/../../src/Pruebas.php';
require_once __DIR__ . '/../../src/PersonasReceptoras.php';
require_once __DIR__ . '/../../src/Usuarios.php';
//User allowed can retrieve the information of all the pruebas. 
//The information return as an Json object
switch($_GET['funcion']){
    case "getAllPruebas":                                  
        echo json_encode(getAllPruebas());                 
        exit;                                                   
    case "buscar":
        echo json_encode(buscar_persona_receptora($_POST['key']));
    default:
        exit;
}
/**
 * Devuelve todas las pruebas
 * Return all the pruebas
 */
function getAllPruebas() {
    try {
        $lista = Pruebas::getAllPruebas();
        // Vamos a editar la lista, y añadir los datos de la persona receptora y el nombre del tecnologo
        // the loop is going to show all the information where there is an instance of Prueba and display the attributes. 
        // The display include the attributes from the tecnologo and Id, poblacion with which identify, poblacion_originatia from the persona receptora  
        foreach($lista as $prueba) {
            $persona_receptora = PersonasReceptoras::getPersonaReceptora($prueba->getId_cedula_persona_receptora());
            $prueba->poblacion = $persona_receptora->getPoblacion();                        
            $prueba->poblacion_originaria = $persona_receptora->getPoblacion_originaria();  
            $tecnologo = Usuarios::getUsuarioById($prueba->getId_tecnologo());
            $prueba->nombre_tecnologo = $tecnologo->getNombre() . ' ' . $tecnologo->getApellidos();
        }
        return prepara_para_json($lista);
    }   // if there are any errors will be catch here and notify with an error message
    catch (Exception $e) {
        $array_response['error'] = 1;
        $array_response['errorMessage'] = $e->getMessage();
        return $array_response;
    }
}

/**
 * Busca una PERSONA RECEPTORA dada una cadena de búsqueda
 * If the  user want to look for a a Person inside the database can be found 
 */
function buscar_persona_receptora($cadena) {
    $array_response['found'] = 1;
    $array_response['error'] = 0;
    try{
        $persona = PersonasReceptoras::getPersonaReceptora($cadena);
        $array_response['poblacion'] = $persona->getPoblacion();                        // the atributes of poblacion and poblacion originaria are
        $array_response['poblacion_originaria'] = $persona->getPoblacion_originaria(); // added to the display
    }
    catch (PersonaReceptoraNotFoundException $e) {
        $array_response['found'] = 0;
    }
    catch (Exception $e){
        $array_response['error'] = 1;
        $array_response['errorMessage'] = $e->getMessage();
        $array_response['found'] = 0;
    }

    return $array_response;
}
// this lines prepare the data coming in an array type, and transforme it in Json
function prepara_para_json($array) {
    return array("data" => $array);
}
?>