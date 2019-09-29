<?php
/**
 * This file returns all the information from the users of FOMODI 
 * If we want to retrieve some infromation the page won't need to request the information to the database because it is already here
 * in json format
 */
require_once __DIR__ . '/../../config/config.php';
// Restringimos el acceso sólo a usuarios administradores
// Restrict the access only to user with the profile adminitrator
$perfiles_aceptados = array('administrador');
require_once __DIR__ . '/../../security/autorizador.php';
// The information from all the user gets load
require_once __DIR__ . '/../../src/Usuarios.php';

//User-Administrador can retrieve the information from all the usuarios and had functionalities such as Activete or disactivate the users. 
//The information return as an Json object
switch($_GET['funcion']){
    case "getAll":
        echo json_encode(getAll());
        exit;
    case "desactivar":
        echo json_encode(desactivar($_POST['id_usuario']));
        exit;
    case "activar":
        echo json_encode(activar($_POST['id_usuario']));
        exit;
    case "buscar":
        echo json_encode(buscar_subreceptor($_GET['key']));
    default:
        exit;
}


/**
 * Devuelve todos los usuarios
 * The function return all the intance of the class Usuarios 
 */
function getAll() {
    try {
        $lista = Usuarios::getAll();

        // Vamos a editar la lista, y en aquellos casos en los que el usuario sea promotor, vamos a añadir un campo nombre_subreceptor, para mostrar el nombre en lugar del id
        // The Usuarios are loaded and if the user is a promotor, it is going to show the name of the subreceptor that they have associated
        foreach($lista as $usuario) {
            if ($usuario->getTipo_de_usuario() === 'promotor') {
                // La siguiente línea puede lanzar una excepción, pero esta sería recogida por el catch general
                // The information of the subreceptor gets shown and if there are any errors, it will be catched by the Exception 
                $subreceptor = Usuarios::getUsuarioById($usuario->getId_subreceptor());
                $usuario->nombre_subreceptor = $subreceptor->getNombre() . ' ' . $subreceptor->getApellidos() . ' (' . $subreceptor->getUbicacion() . ')';
            }
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
 * Desactiva a un usuario, si es posible
 * This function will disactivate the user. Normally used when they stop working for the proyect. 
 */
function desactivar($id_usuario){
    try {
        // Un usuario no puede desactivarse a sí mismo (por motivos de seguriad)
        // The users can only be disactivate by the user administrador. If they try, they will received an error message
        if ($id_usuario == $_SESSION['usuario_id']) {
            $array_response['error'] = 1;
            $array_response['errorMessage'] = "No puedes desactivarte a tí mismo";
            return $array_response;
        }
        $usuario = Usuarios::getUsuarioById($id_usuario);
        $usuario->setActivo(false);

        Usuarios::update($usuario);

        // Todo OK
        // So far there are no errors in the manipulation of the usuarios
        $array_response['error'] = 0;
        return $array_response;
    }
    // If the user has not been found, an error message will be returned
    catch (UsuarioNotFoundException $e) {
        $array_response['error'] = 1;
        $array_response['errorMessage'] = "El usuario no existe";
        return $array_response;
    }
    catch (Exception $e) {
        $array_response['error'] = 1;
        $array_response['errorMessage'] = "Ocurrió un error inesperado";
        return $array_response;
    }
}

/**
 * Desactiva a un usuario, si es posible
 * The function will activate an user that is desactivated but that have all the details in the database
 */
function activar($id_usuario){
    try {
        // Un usuario no puede activarse a sí mismo (por motivos de seguriad). Este caso es muy raro, pero se deja por si pudiera darse 
        // The users can only be disactivate by the user administrador. If they try, they will received an error message
        if ($id_usuario == $_SESSION['usuario_id']) {
            $array_response['error'] = 1;
            $array_response['errorMessage'] = "No puedes activarte a tí mismo";
            return $array_response;
        }
        $usuario = Usuarios::getUsuarioById($id_usuario);
        $usuario->setActivo(true);
        // The status of the user gets change to activo (active)
        Usuarios::update($usuario);

        // Todo OK
        // So far there are no errors
        $array_response['error'] = 0;
        return $array_response;
    }
    // If the user has not been found, an error message will be returned
    catch (UsuarioNotFoundException $e) {
        $array_response['error'] = 1;
        $array_response['errorMessage'] = "El usuario no existe";
        return $array_response;
    }
    catch (Exception $e) {
        $array_response['error'] = 1;
        $array_response['errorMessage'] = "Ocurrió un error inesperado";
        return $array_response;
    }
}

/**
 * Busca un usuario SUBRECEPTOR dada una cadena de búsqueda
 * Search of the user Subreceptor by the searching chain
 */
function buscar_subreceptor ($cadena) {
    try{
        $lista = array();

        // Solo necesitamos el nombre (completo) y el id
        // It is possible to find a subreceptor by name or id
        foreach(Usuarios::buscaUsuarioSubreceptor($cadena) as $subreceptor){
            $lista[] = [
                "nombre" => $subreceptor->getNombre() . ' ' . $subreceptor->getApellidos() . ' (' . $subreceptor->getUbicacion() . ')',
                "id" => $subreceptor->getId()
            ];
        }

        return $lista;
    }
    // if there are any errors, it will be catched here and an error message will be returned to the user
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