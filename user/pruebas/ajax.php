<?php
require_once __DIR__ . '/../../config/config.php';
// Restringimos el acceso sólo a usuarios tecnologos y subreceptores
$perfiles_aceptados = array('tecnologo','subreceptor');
require_once __DIR__ . '/../../security/autorizador.php';
require_once __DIR__ . '/../../src/Pruebas.php';
require_once __DIR__ . '/../../src/PersonasReceptoras.php';
require_once __DIR__ . '/../../src/Usuarios.php';

switch($_GET['funcion']){
    case "getAllPruebas":                                  // estaba cambiando este fichero y haciendolo para pruebas y tecnologos
        echo json_encode(getAllPruebas());                 // me quedo en la linea anterior. Aunque ahora entiendo que se tenga que 
        exit;                                                   // fichero AJAX. 
    case "buscar":
        echo json_encode(buscar_persona_receptora($_POST['key']));
    default:
        exit;
}
/**
 * Devuelve todas las entrevistas
 */
function getAllPruebas() {
    try {
        $lista = Pruebas::getAllPruebas();
        // Vamos a editar la lista, y añadir los datos de la persona receptora y el nombre del tecnologo
        foreach($lista as $prueba) {
            $persona_receptora = PersonasReceptoras::getPersonaReceptora($prueba->getId_persona_receptora());
            $prueba->poblacion = $persona_receptora->getPoblacion();                        // Estaban comentados estos campos, ahora no
            $prueba->poblacion_originaria = $persona_receptora->getPoblacion_originaria();  // me refiero a los de poblacion y poblacion originaria
            $tecnologo = Usuarios::getUsuarioById($prueba->getId_tecnologo());
            $prueba->nombre_tecnologo = $tecnologo->getNombre() . ' ' . $tecnologo->getApellidos();
        }
        return prepara_para_json($lista);
    }
    catch (Exception $e) {
        $array_response['error'] = 1;
        $array_response['errorMessage'] = $e->getMessage();
        return $array_response;
    }
}

/**
 * Busca una PERSONA RECEPTORA dada una cadena de búsqueda
 */
function buscar_persona_receptora($cadena) {
    $array_response['found'] = 1;
    $array_response['error'] = 0;
    try{
        $persona = PersonasReceptoras::getPersonaReceptora($cadena);
        $array_response['poblacion'] = $persona->getPoblacion();
        $array_response['poblacion_originaria'] = $persona->getPoblacion_originaria();
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

function prepara_para_json($array) {
    return array("data" => $array);
}
?>