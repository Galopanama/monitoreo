<?php
/**
 * Este ficehro devuleve toda la informacion de las entrevistas individuales y grupales
 */

require_once __DIR__ . '/../../config/config.php';

// Restringimos el acceso sólo a usuarios administradores
$perfiles_aceptados = array('administrador');
require_once __DIR__ . '/../../security/autorizador.php';

// Llamamos a los siguientes archivos del Modelo
require_once __DIR__ . '/../../src/Entrevistas.php';
require_once __DIR__ . '/../../src/PersonasReceptoras.php';
require_once __DIR__ . '/../../src/Usuarios.php';


// Solo los usuarios con permiso podran recuperar esta informacion
// La informacion se devuelve en un objeto JSon
switch($_GET['funcion']){
    case "getAllIndividuales":
        echo json_encode(getAllIndividuales());
        exit;
    case "getAllGrupales":
        echo json_encode(getAllGrupales());
        exit;
    case "buscar":
        echo json_encode(buscar_subreceptor($_GET['key']));
    default:
        exit;
}


/**
 * Devuelve todas las entrevistas
 */
function getAllIndividuales() {
    try { 
        $lista = Entrevistas::getAllEntrevistasIndividuales();
        // Vamos a editar la lista, y mostrando los datos de la persona receptora y el nombre del promotor
        foreach($lista as $entrevistaIndividual) {
            $persona_receptora = PersonasReceptoras::getPersonaReceptora($entrevistaIndividual->getId_cedula_persona_receptora());
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
 * Devuelve todas las entrevistas grupales
 */
function getAllGrupales() {
    try {
        $lista = Entrevistas::getAllEntrevistasGrupales();

        // Vamos a editar la lista, y añadir los datos de la persona receptora y el nombre del promotor
        foreach($lista as $entrevista) {
            $persona_receptora = PersonasReceptoras::getPersonaReceptora($entrevista->getId_cedula_persona_receptora());
            $entrevista->poblacion = $persona_receptora->getPoblacion();     
            $entrevista->poblacion_originaria = $persona_receptora->getPoblacion_originaria();
                                                                                         
            $promotor = Usuarios::getUsuarioById($entrevista->getId_promotor());
            $entrevista->nombre_promotor = $promotor->getNombre() . ' ' . $promotor->getApellidos();
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
 * Busca a un Subreceptor desde un cadena de caracteres que se recoge en la variable $cadena
 * Si no se encuentra, devolvera un mensaje
 */
function buscar_subreceptor ($cadena) {
    try{
        $lista = array();

        // Solo necesitamos el nombre (completo) y el id
        foreach(Usuarios::buscaUsuarioSubreceptor($cadena) as $subreceptor){
            $lista[] = [
                "nombre" => $subreceptor->getNombre() . ' ' . $subreceptor->getApellidos() . ' (' . $subreceptor->getUbicacion() . ')',
                "id" => $subreceptor->getId()
            ];
        }

        return $lista;
    }
    catch (Exception $e){
        $array_response['error'] = 1;
        $array_response['errorMessage'] = $e->getMessage();
        return $array_response;
    }
}
// Esta funcion convierte un array en un objeto Json
function prepara_para_json($array) {
    return array("data" => $array);
}