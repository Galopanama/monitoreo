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
require_once __DIR__ . '/../../src/PersonasReceptoras.php';
require_once __DIR__ . '/../../src/Usuarios.php';
require_once __DIR__ . '/../../src/Alcanzado.php';


//the user can retrieve the information of all the interviews. 
//The information return as an Json object
switch($_GET['funcion']){
    case "getPersonasAlcanzadasByPoblacion":
        echo json_encode(getPersonasAlcanzadasByPoblacion());
        exit;
    case "getPersonasAlcanzadasByDate":
        echo json_encode(getPersonasAlcanzadasByDate($_POST["desde"], $_POST["hasta"]));
        exit;
    default:
        exit;
}

/**
 * Devuelve todas las personas receptoras Alcanzadas
 * Return all the Personas receptoras Alcanzadas
 */
function getPersonasAlcanzadasByDate($desde, $hasta) {

    // Validar los parametros de fecha $desde y $hasta
    
    try {
        $desde = DateTime::createFromFormat ( 'Y-m-d' ,$_POST['desde']); 
        $hasta = DateTime::createFromFormat ( 'Y-m-d' ,$_POST['hasta']);

        function validar_fecha($fecha){
            $valores = explode('/', $fecha);
            if(count($valores) == 3 && checkdate($valores[1], $valores[0], $valores[2])){
                return true;
            }
            return false;
        }
        
        // Ahi estan la conversion del las fechas a un formato especifico, y despues esta la funcion que comprueba 
        // la valides de los datos introducidos por el usuario. Ahora, la pregunta es como se ensambla

    }

    try {
        if ($_SESSION['tipo_de_usuario'] === 'subreceptor'){
            // Si el usuario es un promotor, pasamos su id en el campo id_promotor
            // If the user is promotor, we pass the id to show only the interviews with the same id
            $lista = Entrevistas::getAlcanzado($_SESSION['usuario_id']); // The object Entrevista gets called
        }

        // Vamos a editar la lista, y añadir los datos de la persona receptora 
        // Edit a list with all the instances of class Persona Receptora and name 
        foreach($lista as $entrevista) {
            $persona_receptora = PersonasReceptoras::getPersonaReceptora($entrevista->getId_cedula_persona_receptora()); // mismo cambio que las anteriores funciones
            $entrevista->poblacion = $persona_receptora->getPoblacion();      
            $entrevista->poblacion_originaria = $persona_receptora->getPoblacion_originaria();
                                                                                        
            $subreceptor = Usuarios::getUsuarioById($entrevista->getId_subreceptor());
            $entrevista->nombre_subreceptor = $subreceptor->getNombre();
        }

        return prepara_para_json($lista);



    }// If there is any exception, send and error message
    catch (Exception $e) {
        $array_response['error'] = 1;
        $array_response['errorMessage'] = $e->getMessage();
        return $array_response;
    }
}

// Function to convert and array to json  
function prepara_para_json($array) {
    return array("data" => $array);
}