<?php
/**
 * This file returns all the interviews from the individuals and groups 
 * The information can it can be searched by the organisantions' name as well as just the name of the Promotor
 */
require_once __DIR__ . '/../../config/config.php';
// Restringimos el acceso sólo a usuarios promotores y subreceptores
// it is only permited the access to the user 'promotor' and 'subreceptor'
$perfiles_aceptados = array('promotor', 'subreceptor');
require_once __DIR__ . '/../../security/autorizador.php';
// Llama a los siguientes archivos del Modelo
// Call the files from the Model
require_once __DIR__ . '/../../src/Entrevistas.php';
require_once __DIR__ . '/../../src/PersonasReceptoras.php';
require_once __DIR__ . '/../../src/Usuarios.php';


//the user can retrieve the information of all the interviews. 
//The information return as an Json object
switch($_GET['funcion']){
    case "getAllIndividuales":
        echo json_encode(getAllIndividuales());
        exit;
    case "getAllGrupales":
        echo json_encode(getAllGrupales());
        exit;
    case "getAlcanzados":
        echo json_encode(getAlcanzados());
        exit;
    case "buscar":
        echo json_encode(buscar_persona_receptora($_POST['key']));
    default:
        exit;
}


/**
 * Devuelve todas las entrevistas individuales
 * Return all the personal interviews
 */
function getAllIndividuales() {
    try {
        if($_SESSION['tipo_de_usuario'] === 'promotor'){
            // Si el usuario es un promotor, pasamos su id en el campo id_promotor
            // If the user is promotor, we pass the id to show only the interviews with the same id
            $lista = Entrevistas::getAllEntrevistasIndividuales($_SESSION['usuario_id'], null); // The object Entrevista gets called
        }
        else if ($_SESSION['tipo_de_usuario'] === 'subreceptor'){
            // Si el usuario es subreceptor, pasamos el segundo argumento al método para indicar el id
            // If the user is subreceptor, we pass the id and only return the objects that contains the same id
            $lista = Entrevistas::getAllEntrevistasIndividuales(null, $_SESSION['usuario_id']); // The object Entrevista gets called
        }

        // Vamos a editar la lista, y añadir los datos de la persona receptora y el nombre del promotor
        // Edit a list with all the instances of class Persona Receptora and name and Id from Promotor
        foreach($lista as $entrevista) {
            $persona_receptora = PersonasReceptoras::getPersonaReceptora($entrevista->getId_persona_receptora());
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
 * Devuelve todas las entrevistas grupales
 * Returns all the group interviews
 */
function getAllGrupales() {
    try {
        if($_SESSION['tipo_de_usuario'] === 'promotor'){
            // Si el usuario es un promotor, pasamos su id en el campo id_promotor
            // If the user is promotor, we pass the id to show only the interviews with the same id
            $lista = Entrevistas::getAllEntrevistasGrupales($_SESSION['usuario_id'], null);
        }
        else if ($_SESSION['tipo_de_usuario'] === 'subreceptor'){
            // Si el usuario es subreceptor, pasamos el segundo argumento al método para indicar el id
            $lista = Entrevistas::getAllEntrevistasGrupales(null, $_SESSION['usuario_id']);
        }

        // Vamos a editar la lista, y añadir los datos de la persona receptora y el nombre del promotor
        // Return the list of interviews with te id and name of the Promotor 
        foreach($lista as $entrevista) {
            $persona_receptora = PersonasReceptoras::getPersonaReceptora($entrevista->getId_persona_receptora());
            $entrevista->poblacion = $persona_receptora->getPoblacion();                        // esto se hace para añadir atributos a un objeto que no 
            $entrevista->poblacion_originaria = $persona_receptora->getPoblacion_originaria();  // son parte del objeto en si. Solo se hace
                                                                                                // porque PHP lo permite. igual que Java 
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
 * Devuelve todas las personas receptoras Alcanzadas
 * Return all the Personas receptoras Alcanzadas
 */
function getAlcanzados() {
    try {
        if($_SESSION['tipo_de_usuario'] === 'promotor'){
            // Si el usuario es un promotor, pasamos su id en el campo id_promotor
            // If the user is promotor, we pass the id to show only the interviews with the same id
            $lista = Entrevistas::getAlcanzado($_SESSION['usuario_id'], null); // The object Entrevista gets called
        }
        else if ($_SESSION['tipo_de_usuario'] === 'subreceptor'){
            // Si el usuario es subreceptor, pasamos el segundo argumento al método para indicar el id
            // If the user is subreceptor, we pass the id and only return the objects that contains the same id
            $lista = Entrevistas::getAlcanzado(null, $_SESSION['usuario_id']); // The object Entrevista gets called
        }

        // Vamos a editar la lista, y añadir los datos de la persona receptora y el nombre del promotor
        // Edit a list with all the instances of class Persona Receptora and name and Id from Promotor
        foreach($lista as $entrevista) {
            $persona_receptora = PersonasReceptoras::getPersonaReceptora($entrevista->getId_persona_receptora());
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
 * Busca una PERSONA RECEPTORA dada una cadena de búsqueda
 * Look for the object Persona Receptora and return the atributes detailed
 * If not found will return a message to inform about it
 * If any other error, return a message to inform about it 
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
// Function to convert and array to json  
function prepara_para_json($array) {
    return array("data" => $array);
}