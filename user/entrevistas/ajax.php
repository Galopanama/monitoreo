<?php
require_once __DIR__ . '/../../config/config.php';
// Restringimos el acceso sólo a usuarios promotores y subreceptores
$perfiles_aceptados = array('promotor', 'subreceptor');
require_once __DIR__ . '/../../security/autorizador.php';
require_once __DIR__ . '/../../src/Entrevistas.php';
require_once __DIR__ . '/../../src/PersonasReceptoras.php';
require_once __DIR__ . '/../../src/Usuarios.php';

switch($_GET['funcion']){
    case "getAllIndividuales":
        echo json_encode(getAllIndividuales());
        exit;
    case "buscar":
        echo json_encode(buscar_persona_receptora($_POST['key']));
    default:
        exit;
}


/**
 * Devuelve todas las entrevistas
 */
function getAllIndividuales() {
    try {
        if($_SESSION['tipo_de_usuario'] === 'promotor'){
            // Si el usuario es un promotor, pasamos su id en el campo id_promotor
            $lista = Entrevistas::getAllEntrevistasIndividuales($_SESSION['usuario_id'], null);
        }
        else if ($_SESSION['tipo_de_usuario'] === 'subreceptor'){
            // Si el usuario es subreceptor, pasamos el segundo argumento al método para indicar el id
            $lista = Entrevistas::getAllEntrevistasIndividuales(null, $_SESSION['usuario_id']);
        }

        // Vamos a editar la lista, y añadir los datos de la persona receptora y el nombre del promotor
        foreach($lista as $entrevistaIndividual) {
            $persona_receptora = PersonasReceptoras::getPersonaReceptora($entrevistaIndividual->getId_persona_receptora());
            $entrevistaIndividual->poblacion = $persona_receptora->getPoblacion();
            $entrevistaIndividual->poblacion_originaria = $persona_receptora->getPoblacion_originaria();

            $promotor = Usuarios::getUsuarioById($entrevistaIndividual->getId_promotor());
            $entrevistaIndividual->nombre_promotor = $promotor->getNombre() . ' ' . $promotor->getApellidos();
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