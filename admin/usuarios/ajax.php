<?php
require_once __DIR__ . '/../../config/config_admin.php';
require_once __DIR__ . '/../../src/Usuarios.php';

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
    default:
        exit;
}


/**
 * Devuelve todos los usuarios
 */
function getAll() {
    $lista = Usuarios::getAll();
    
    return prepara_para_json($lista);
}

/**
 * Desactiva a un usuario, si es posible
 */
function desactivar($id_usuario){
    try {
        // Un usuario no puede desactivarse a sí mismo (por motivos de seguriad)
        if ($id_usuario == $_SESSION['usuario_id']) {
            $array_response['error'] = 1;
            $array_response['errorMessage'] = "No puedes desactivarte a tí mismo";
            return $array_response;
        }
        $usuario = Usuarios::getUsuarioById($id_usuario);
        $usuario->setActivo(false);

        Usuarios::update($usuario);

        // Todo OK
        $array_response['error'] = 0;
        return $array_response;
    }
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
 */
function activar($id_usuario){
    try {
        // Un usuario no puede activarse a sí mismo (por motivos de seguriad). Este caso es muy raro, pero se deja por si pudiera darse 
        if ($id_usuario == $_SESSION['usuario_id']) {
            $array_response['error'] = 1;
            $array_response['errorMessage'] = "No puedes activarte a tí mismo";
            return $array_response;
        }
        $usuario = Usuarios::getUsuarioById($id_usuario);
        $usuario->setActivo(true);

        Usuarios::update($usuario);

        // Todo OK
        $array_response['error'] = 0;
        return $array_response;
    }
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

function prepara_para_json($array) {
    return array("data" => $array);
}