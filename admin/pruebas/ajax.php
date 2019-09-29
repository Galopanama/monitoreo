<?php
/**
 * This file returns all the pruebas from the individuals and groups 
 * The information can it can be searched by the organisantions' name as well as just the name of the Promotor
 */
require_once __DIR__ . '/../../config/config.php';
// Restringimos el acceso sólo a usuarios administradores
// it is only permited the access to the user 'administrador'
$perfiles_aceptados = array('administrador');
require_once __DIR__ . '/../../security/autorizador.php';
// Call the files from the Model
require_once __DIR__ . '/../../src/Pruebas.php';
require_once __DIR__ . '/../../src/PersonasReceptoras.php';
require_once __DIR__ . '/../../src/Usuarios.php';
//User-Administrador can retrieve the information from all the pruebas. 
//The information return as an Json object
switch($_GET['funcion']){
    case "getAllPruebas":
        echo json_encode(getAllPruebas());
        exit;
    case "buscar":
        echo json_encode(buscar_subreceptor($_GET['key']));
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
        // The display include the attributes from the tecnologo and Id from the persona receptora   
        foreach($lista as $prueba) {
            $persona_receptora = PersonasReceptoras::getPersonaReceptora($prueba->getId_cedula_persona_receptora());
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
 * Busca un usuario SUBRECEPTOR dada una cadena de búsqueda
 * If the administrador want to observe to the information about a specific subreceptor and the number of test that have been done
 * if would use the following lines
 */
function buscar_subreceptor ($cadena) {
    try{
        $lista = array();

        // Solo necesitamos el nombre (completo) y el id
        // The data display will be the pruebas that have the name of the subreceptor with the data from the user that has done the test
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
// The data stores in a array gets transformed in json 
function prepara_para_json($array) {
    return array("data" => $array);
}