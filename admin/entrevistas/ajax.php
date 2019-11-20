<?php
/**
 * This file returns all the interviews from the individuals and groups 
 * The information can it can be searched by the organisantions' name as well as just the name of the Promotor
 */
require_once __DIR__ . '/../../config/config.php';
// Restringimos el acceso sólo a usuarios administradores
// it is only permited the access to the user 'administrador'
$perfiles_aceptados = array('administrador');
require_once __DIR__ . '/../../security/autorizador.php';
// Call the files from the Model
require_once __DIR__ . '/../../src/Entrevistas.php';
require_once __DIR__ . '/../../src/PersonasReceptoras.php';
require_once __DIR__ . '/../../src/Usuarios.php';
//User can retrieve the information of all the interviews. 
//The information return as an Json object
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
 * Returns all the individual interviews
 */
function getAllIndividuales() {
    try { 
        $lista = Entrevistas::getAllEntrevistasIndividuales();// The object Entrevista gets called
        // It is diplayed one object for iteration of the code showing the atributes implicits in the Individual interview
        // Vamos a editar la lista, y mostrando los datos de la persona receptora y el nombre del promotor
        foreach($lista as $entrevistaIndividual) {
            $persona_receptora = PersonasReceptoras::getPersonaReceptora($entrevistaIndividual->getId_cedula_persona_receptora());
            $entrevistaIndividual->poblacion = $persona_receptora->getPoblacion();   // Php allows to bring atributes from another table and display it here
            $entrevistaIndividual->poblacion_originaria = $persona_receptora->getPoblacion_originaria();// This values are relevants for the user
            // adds the information about the promotor who introduced the data in the system
            $promotor = Usuarios::getUsuarioById($entrevistaIndividual->getId_promotor());
            $entrevistaIndividual->nombre_promotor = $promotor->getNombre() . ' ' . $promotor->getApellidos();
        }

        return prepara_para_json($lista);
    }// If there is any exception, send and error message
    catch (Exception $e) {
        $array_response['error'] = 1;
        $array_response['errorMessage'] = $e->getMessage();
        return $array_response;
    }
}

/**
 * Devuelve todas las entrevistas grupales
 * Returns all the group interviews
 */
function getAllGrupales() {
    try {
        $lista = Entrevistas::getAllEntrevistasGrupales();

        // Vamos a editar la lista, y añadir los datos de la persona receptora y el nombre del promotor
        // Edit a list with all the instances of class Persona Receptora and name and Id from Promotor
        foreach($lista as $entrevista) {
            $persona_receptora = PersonasReceptoras::getPersonaReceptora($entrevista->getId_cedula_persona_receptora());
            $entrevista->poblacion = $persona_receptora->getPoblacion();     
            $entrevista->poblacion_originaria = $persona_receptora->getPoblacion_originaria();
                                                                                         
            $promotor = Usuarios::getUsuarioById($entrevista->getId_promotor());
            $entrevista->nombre_promotor = $promotor->getNombre() . ' ' . $promotor->getApellidos();
        }

        return prepara_para_json($lista);
    }// If there is any exception, send and error message
    catch (Exception $e) {
        $array_response['error'] = 1;
        $array_response['errorMessage'] = $e->getMessage();
        return $array_response;
    }
}


/**
 * Look for an user Subreceptor with the information given in the variable $cadena
 * If not found will return a error message 
 * Busca un usuario SUBRECEPTOR dada una cadena de búsqueda
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
// Function to convert and array to json
function prepara_para_json($array) {
    return array("data" => $array);
}