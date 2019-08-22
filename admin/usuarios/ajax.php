<?php
require_once __DIR__ . '/../../config/config_admin.php';
require_once __DIR__ . '/../../src/Usuarios.php';

switch($_GET['funcion']){
    case "getAll":
        echo json_encode(getAll());
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

function prepara_para_json($array) {
    return array("data" => $array);
}